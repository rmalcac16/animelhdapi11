<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Anime;

class Animes extends Component
{
    public $showModal = false;

    protected $listeners = [
        'openAddAnimeModal' => 'showAddAnimeModal',
    ];

    public function showAddAnimeModal()
    {
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.animes');
    }
}
