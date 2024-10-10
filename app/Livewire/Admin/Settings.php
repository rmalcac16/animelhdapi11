<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\File;

class Settings extends Component
{
    public $apiKeys = [
        'voe' => '',
        'filemoon' => '',
        'lulustream' => '',
        'tmdb' => '',
        'mal' => '',
    ];
    public $jsonContent = [];

    public function mount()
    {
        session()->forget(['message', 'error', 'success']);

        $filePath = storage_path('app/api_keys.json');

        if (File::exists($filePath)) {
            $this->jsonContent = json_decode(File::get($filePath), true);
            $this->apiKeys = array_merge($this->apiKeys, $this->jsonContent);
        }
    }

    public function saveApiKeys()
    {
        $filePath = storage_path('app/api_keys.json');
        
        File::put($filePath, json_encode($this->apiKeys, JSON_PRETTY_PRINT));

        session()->flash('message', __('API keys saved successfully.'));
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
