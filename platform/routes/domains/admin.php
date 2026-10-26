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
use App\Http\Livewire\Admin\AnalyticsIndex;

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardIndex::class)->name('dashboard');
    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/users/{user}', UserShow::class)->name('users.show');
    Route::get('/components', ComponentIndex::class)->name('components.index');
    Route::get('/themes', ThemeIndex::class)->name('themes.index');
    Route::get('/templates', TemplateIndex::class)->name('templates.index');
    Route::get('/posts', PostIndex::class)->name('posts.index');
    Route::get('/settings', SettingsIndex::class)->name('settings');
    Route::get('/analytics', AnalyticsIndex::class)->name('analytics');
});
