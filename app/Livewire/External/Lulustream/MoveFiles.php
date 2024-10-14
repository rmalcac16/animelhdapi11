<?php

namespace App\Livewire\External\Lulustream;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

use Livewire\Component;

class MoveFiles extends Component
{
    public $folderId = 0;
    public $destinationFolderId;
    public $files = [];
    public $selectedFiles = [];
    public $apiKey = '';
    public $successCount = 0;
    public $failureCount = 0;

    public function mount()
    {
        session()->forget(['message', 'error', 'success']);

        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $apiKeys = json_decode(File::get($filePath), true);
            if (filled($apiKeys['lulustream'])) {
                $this->apiKey = $apiKeys['lulustream'];
            } else {
                session()->flash('error', __('API Key for Lulustream is not configured. Please configure it first.'));
            }
        } else {
            session()->flash('error', __('The API keys file does not exist. Please configure the API Key for Lulustream.'));
        }
    }

    public function getFiles()
    {
        $response = Http::get('https://lulustream.com/api/file/list', [
            'key' => $this->apiKey,
            'fld_id' => $this->folderId,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['result']['files'])) {
                $this->files = $data['result']['files'];
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

        if ($this->destinationFolderId === null || $this->destinationFolderId === '') {
            session()->flash('message', __('Please enter the destination folder ID.'));
            return;
        }

        $this->successCount = 0;
        $this->failureCount = 0;

        foreach ($this->selectedFiles as $fileCode) {
            
            $response = Http::get('https://api.lulustream.com/api/file/edit', [
                'key' => $this->apiKey,
                'file_code' => $fileCode,
                'file_fld_id' => $this->destinationFolderId,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['status']) && $data['status'] == 200) {
                    $this->successCount++;
                } else {
                    $this->failureCount++;
                }
            } else {
                $this->failureCount++;
            }
        }

        $message = __("Files successfully moved: :success. Failed: :failure.", [
            'success' => $this->successCount,
            'failure' => $this->failureCount,
        ]);
        
        $this->resetFields();
        session()->flash('success', $message);
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
        return view('livewire.external.lulustream.move-files');
    }
}
