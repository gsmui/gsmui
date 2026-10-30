<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', fn () => view('livewire.dashboard.overview'))->name('');
    Route::get('/projects', fn () => view('livewire.dashboard.project-management'))->name('projects');
    Route::get('/favorites', fn () => view('livewire.dashboard.favorites'))->name('favorites');
    Route::get('/subscription', fn () => view('livewire.dashboard.subscription'))->name('subscription');
    Route::get('/api-keys', fn () => view('livewire.dashboard.api-key-management'))->name('api-keys');
    Route::get('/profile', fn () => view('livewire.dashboard.profile'))->name('profile');
});
