<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Components\ComponentIndex;
use App\Http\Livewire\Components\ComponentShow;
use App\Http\Livewire\Components\ComponentCreate;
use App\Http\Livewire\Components\ComponentEdit;

// Component library routes
Route::get('/components', ComponentIndex::class)->name('components.index');
Route::get('/components/create', ComponentCreate::class)->name('components.create')->middleware('auth');
Route::get('/components/{slug}', ComponentShow::class)->name('components.show');
Route::get('/components/{slug}/edit', ComponentEdit::class)->name('components.edit')->middleware('auth');
