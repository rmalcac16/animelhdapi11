<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use App\Models\User;
use App\Models\Anime;
use App\Models\Genre;

class Dashboard extends Component
{

    public $usersCount = 0;
    public $animesCount = 0;
    public $genresCount = 0;
    public $episodesCount = 0;
    
    public $topAnimes = [];

    public function mount()
    {
        session()->forget(['message', 'error', 'success']);

        $this->usersCount = User::count();
        $this->animesCount = Anime::count();
        $this->genresCount = Genre::count();

        $this->topAnimes = Anime::orderBy('views_app', 'desc')->limit(5)->get();

        //$this->episodesCount = Episode::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
