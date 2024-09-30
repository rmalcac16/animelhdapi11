<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\Dashboard;
use App\Livewire\External\Voe\MoveFiles;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function(){

    Route::get('/', Dashboard::class)->name('dashboard');

    // Voe
    Route::name('external.')->prefix('external')->group(function(){
        Route::name('voe.')->prefix('voe')->group(function(){
            Route::get('move', MoveFiles::class)->name('move');
        });
    });
});
