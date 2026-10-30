<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\DashboardIndex;
use App\Http\Livewire\Admin\UserIndex;
use App\Http\Livewire\Admin\UserShow;
use App\Http\Livewire\Admin\ComponentIndex;
use App\Http\Livewire\Admin\ThemeIndex;
use App\Http\Livewire\Admin\TemplateIndex;
use App\Http\Livewire\Admin\PostIndex;
use App\Http\Livewire\Admin\SettingsIndex;

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardIndex::class)->name('dashboard');
    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/users/{user}', UserShow::class)->name('users.show');
// Route::get('/components', ComponentIndex::class)->name('components.index');  // TODO: App\Http\Livewire\Admin\ComponentIndex does not exist yet
// Route::get('/themes', ThemeIndex::class)->name('themes.index');  // TODO: App\Http\Livewire\Admin\ThemeIndex does not exist yet
// Route::get('/templates', TemplateIndex::class)->name('templates.index');  // TODO: App\Http\Livewire\Admin\TemplateIndex does not exist yet
// Route::get('/posts', PostIndex::class)->name('posts.index');  // TODO: App\Http\Livewire\Admin\PostIndex does not exist yet
// Route::get('/settings', SettingsIndex::class)->name('settings');  // TODO: App\Http\Livewire\Admin\SettingsIndex does not exist yet
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});
