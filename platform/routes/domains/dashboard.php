<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard\DashboardIndex;
use App\Http\Livewire\Dashboard\ProfileShow;
use App\Http\Livewire\Dashboard\ProfileEdit;
use App\Http\Livewire\Dashboard\FavoritesIndex;
use App\Http\Livewire\Dashboard\ProjectsIndex;
use App\Http\Livewire\Dashboard\NotificationsIndex;
use App\Http\Livewire\Dashboard\ApiKeysIndex;

// Dashboard routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');
    Route::get('/dashboard/profile', ProfileShow::class)->name('dashboard.profile');
    Route::get('/dashboard/profile/edit', ProfileEdit::class)->name('dashboard.profile.edit');
    Route::get('/dashboard/favorites', FavoritesIndex::class)->name('dashboard.favorites');
    Route::get('/dashboard/projects', ProjectsIndex::class)->name('dashboard.projects');
    Route::get('/dashboard/notifications', NotificationsIndex::class)->name('dashboard.notifications');
    Route::get('/dashboard/api-keys', ApiKeysIndex::class)->name('dashboard.api-keys');
});
