<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Settings;
use App\Livewire\External\Voe\MoveFiles;

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

    // Voe
    Route::name('external.')->prefix('external')->group(function(){
        Route::name('voe.')->prefix('voe')->group(function(){
            Route::get('move', MoveFiles::class)->name('move');
        });
    });
});
