<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Blog\BlogIndex;
use App\Http\Livewire\Blog\BlogShow;
use App\Http\Livewire\Blog\BlogCreate;
use App\Http\Livewire\Blog\BlogEdit;

// Blog routes
Route::get('/blog', BlogIndex::class)->name('blog.index');
// Route::get('/blog/create', BlogCreate::class)->name('blog.create')->middleware('auth');  // TODO: App\Http\Livewire\Blog\BlogCreate does not exist yet
Route::get('/blog/{slug}', BlogShow::class)->name('blog.show');
// Route::get('/blog/{slug}/edit', BlogEdit::class)->name('blog.edit')->middleware('auth');  // TODO: App\Http\Livewire\Blog\BlogEdit does not exist yet
