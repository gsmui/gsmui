<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Themes\ThemeIndex;
use App\Http\Livewire\Themes\ThemeShow;
use App\Http\Livewire\Themes\ThemeCreate;
use App\Http\Livewire\Themes\ThemeEdit;

// Theme routes
Route::get('/themes', ThemeIndex::class)->name('themes.index');
Route::get('/themes/create', ThemeCreate::class)->name('themes.create')->middleware('auth');
Route::get('/themes/{slug}', ThemeShow::class)->name('themes.show');
Route::get('/themes/{slug}/edit', ThemeEdit::class)->name('themes.edit')->middleware('auth');
