<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Showcase\ShowcaseIndex;
use App\Http\Livewire\Showcase\ShowcaseShow;
use App\Http\Livewire\Showcase\ShowcaseCreate;
use App\Http\Livewire\Showcase\ShowcaseEdit;

// Showcase routes
Route::get('/showcase', ShowcaseIndex::class)->name('showcase.index');
Route::get('/showcase/create', ShowcaseCreate::class)->name('showcase.create')->middleware('auth');
Route::get('/showcase/{slug}', ShowcaseShow::class)->name('showcase.show');
Route::get('/showcase/{slug}/edit', ShowcaseEdit::class)->name('showcase.edit')->middleware('auth');
