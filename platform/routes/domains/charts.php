<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Charts\ChartIndex;
use App\Http\Livewire\Charts\ChartShow;
use App\Http\Livewire\Charts\ChartCreate;

// Chart routes
Route::get('/charts', ChartIndex::class)->name('charts.index');
Route::get('/charts/create', ChartCreate::class)->name('charts.create')->middleware('auth');
Route::get('/charts/{slug}', ChartShow::class)->name('charts.show');
