<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Settings;

use App\Http\Controllers\Admin\AnimeController;

Route::get('/', function () {
    return view('welcome');
});

if (env('AUTH_ROUTES_ENABLED', true)) {
    Auth::routes([
        'register' => env('REGISTER_ROUTE_ENABLED', true),
        'reset' => env('PASSWORD_RESET_ROUTE_ENABLED', true),
    ]);
}

Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function(){

    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/settings', Settings::class)->name('settings');

    Route::get('animes/generate', [AnimeController::class, 'generate'])->name('animes.generate');
    Route::post('animes/store-tmdb', [AnimeController::class, 'storeTmdb'])->name('animes.storeTmdb');
    Route::get('animes/fetch-anime-data', [AnimeController::class, 'fetchAnimeData'])->name('animes.fetchanimedata');
    Route::get('animes/fetch-anime-data-id', [AnimeController::class, 'fetchAnimeDataById'])->name('animes.fetchanimedataid');
    Route::get('animes/data', [AnimeController::class, 'getAnimesData'])->name('animes.data');
    Route::resource('animes', AnimeController::class);
    

    // Voe
    Route::name('external.')->prefix('external')->group(function(){
        Route::name('voe.')->prefix('voe')->group(function(){
            Route::get('move', App\Livewire\External\Voe\MoveFiles::class)->name('move');
            Route::get('clone', App\Livewire\External\Voe\CloneFiles::class)->name('clone');
        });
        Route::name('filemoon.')->prefix('filemoon')->group(function(){
            Route::get('clone', App\Livewire\External\Filemoon\CloneFiles::class)->name('clone');
        });
        Route::name('lulustream.')->prefix('lulustream')->group(function(){
            Route::get('clone', App\Livewire\External\Lulustream\CloneFiles::class)->name('clone');
        });
    });
});
