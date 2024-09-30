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
    public $selectAll = false;

    public $sortField = 'name';
    public $sortDirection = 'asc'; 

    public $apiKey = '';

    public function mount()
    {
        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $apiKeys = json_decode(File::get($filePath), true);
            if (filled($apiKeys['voe'])) {
                $this->apiKey = $apiKeys['voe'];
            } else {
                session()->flash('message', __('API Key for Voe is not configured. Please configure it first.'));
            }
        } else {
            session()->flash('message', __('The API keys file does not exist. Please configure the API Key for Voe.'));
        }
    }

    public function updatingSelectAll($value)
    {
        if ($value) {
            $this->selectedFiles = collect($this->files)->pluck('file_code')->toArray();
        } else {
            $this->selectedFiles = [];
        }
    }

    public function updatedSelectedFiles()
    {
        $this->selectAll = count($this->selectedFiles) === count($this->files);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->getFiles();
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

                $this->files = collect($this->files)->sortBy(function ($file) {
                    return strtolower($file[$this->sortField] ?? '');
                }, SORT_REGULAR, $this->sortDirection === 'desc')->values()->toArray();

                $this->selectedFiles = [];
                $this->selectAll = false;
            } else {
                $this->files = [];
                session()->flash('message', __('No files found in this folder.'));
            }
        } else {
            $this->files = [];
            session()->flash('message', __('Could not retrieve the file list from the API.'));
        }
    }

    public function updatedFolderId()
    {
        $this->getFiles();
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
        session()->flash('message', $message);

        $this->getFiles();

        $this->selectedFiles = [];
        $this->selectAll = false;
    }

    public function render()
    {
        return view('livewire.external.voe.move-files');
    }
}
