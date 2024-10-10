<?php

namespace App\Livewire\External\Filemoon;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class CloneFiles extends Component
{
    public $folderId;
    public $fileCodes;
    public $responses = [];
    public $clonedFiles = [];
    public $successfulClones = 0;
    public $failedClones = 0;
    public $apiKey = '';

    public function mount()
    {
        session()->forget(['message', 'error', 'success']);

        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $apiKeys = json_decode(File::get($filePath), true);
            if (filled($apiKeys['filemoon'])) {
                $this->apiKey = $apiKeys['filemoon'];
            } else {
                session()->flash('error', __('API Key for Filemoon is not configured. Please configure it first.'));
            }
        } else {
            session()->flash('error', __('The API keys file does not exist. Please configure the API Key for Filemoon.'));
        }
    }

    public function cloneFiles()
    {
        $fileCodesArray = preg_split("/[\s,]+/", $this->fileCodes);
        $this->successfulClones = 0;
        $this->failedClones = 0;
        $this->responses = [];
        $this->clonedFiles = [];

        foreach ($fileCodesArray as $fileCode) {
            if (preg_match('/[ed]\/([a-zA-Z0-9]+)/', $fileCode, $matches)) {
                $extractedCode = $matches[1];
            } else {
                session()->flash('error', __("The provided URL format is incorrect: $fileCode"));
                continue;
            }
            $response = Http::get('https://filemoon.sx/api/file/clone', [
                'key' => $this->apiKey,
                'file_code' => $extractedCode,
                'fld_id' => $this->folderId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] == 200 && $data['msg'] == 'OK') {
                    $this->successfulClones++;
                    $this->clonedFiles[] = [
                        'file_name' => $data['result']['file_code'],
                        'url_embed' => str_replace("d/", "e/" , $data['result']['url']),
                    ];
                } else {
                    $this->failedClones++;
                }
                $this->responses[] = $data;
            } else {
                $this->failedClones++;
            }
        }

        session()->flash('message', __('Clone process completed.'));
    }

    public function render()
    {
        return view('livewire.external.filemoon.clone-files');
    }
}
