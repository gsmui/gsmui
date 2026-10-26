<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Playground\PlaygroundIndex;
use App\Http\Livewire\Playground\PlaygroundShow;

// Playground routes
Route::get('/playground', PlaygroundIndex::class)->name('playground.index');
Route::get('/playground/{slug}', PlaygroundShow::class)->name('playground.show');
