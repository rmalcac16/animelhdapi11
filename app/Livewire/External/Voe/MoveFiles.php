<?php

namespace App\Livewire\External\Voe;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class MoveFiles extends Component
{
    public $folderId = 0;
    public $destinationFolderId;
    public $files = [];
    public $selectedFiles = [];
    public $apiKey = '';

    public function mount()
    {
        session()->forget(['message', 'error', 'success']);

        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $apiKeys = json_decode(File::get($filePath), true);
            if (filled($apiKeys['voe'])) {
                $this->apiKey = $apiKeys['voe'];
            } else {
                session()->flash('error', __('API Key for Voe is not configured. Please configure it first.'));
            }
        } else {
            session()->flash('error', __('The API keys file does not exist. Please configure the API Key for Voe.'));
        }
    }

    public function getFiles()
    {
        $response = Http::get('https://voe.sx/api/folder/list', [
            'key' => $this->apiKey,
            'fld_id' => $this->folderId,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['result']['files']['data'])) {
                $this->files = $data['result']['files']['data'];
                $this->selectedFiles = [];
                $this->dispatch('files-updating');
            } else {
                $this->files = [];
                session()->flash('message', __('No files found in this folder.'));
            }
        } else {
            $this->files = [];
            session()->flash('message', __('Could not retrieve the file list from the API.'));
        }
    }

    public function moveSelectedFiles()
    {
        
        if (empty($this->selectedFiles)) {
            session()->flash('message', __('No files selected for moving.'));
            return;
        }

        if (!$this->destinationFolderId) {
            session()->flash('message', __('Please enter the destination folder ID.'));
            return;
        }

        $successCount = 0;
        $failureCount = 0;

        foreach ($this->selectedFiles as $fileCode) {
            $response = Http::get('https://voe.sx/api/file/set_folder', [
                'key' => $this->apiKey,
                'file_code' => $fileCode,
                'fld_id' => $this->destinationFolderId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['success']) {
                    $successCount++;
                } else {
                    $failureCount++;
                }
            } else {
                $failureCount++;
            }
        }

        $message = __("Files successfully moved: :success. Failed: :failure.", ['success' => $successCount, 'failure' => $failureCount]);
        $this->resetFields();
        session()->flash('message', $message);
    }

    public function resetFields()
    {
        $this->destinationFolderId = null;
        $this->files = [];
        $this->selectedFiles = [];
        $this->dispatch('files-updating');
    }

    public function render()
    {
        return view('livewire.external.voe.move-files');
    }
}
