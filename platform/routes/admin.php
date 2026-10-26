<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('livewire.admin.dashboard'))->name('dashboard');
    Route::get('/users', fn () => view('livewire.admin.user-management'))->name('users.index');
    Route::get('/components', fn () => view('livewire.admin.component-management'))->name('components.index');
    Route::get('/templates', fn () => view('livewire.admin.template-management'))->name('templates.index');
    Route::get('/themes', fn () => view('livewire.admin.theme-management'))->name('themes.index');
    Route::get('/posts', fn () => view('livewire.admin.post-management'))->name('posts.index');
    Route::get('/showcases', fn () => view('livewire.admin.showcase-management'))->name('showcases.index');
    Route::get('/settings', fn () => view('pages.admin.settings'))->name('settings');
});
