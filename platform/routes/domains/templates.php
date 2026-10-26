<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Templates\TemplateIndex;
use App\Http\Livewire\Templates\TemplateShow;
use App\Http\Livewire\Templates\TemplateCreate;
use App\Http\Livewire\Templates\TemplateEdit;

// Template routes
Route::get('/templates', TemplateIndex::class)->name('templates.index');
Route::get('/templates/create', TemplateCreate::class)->name('templates.create')->middleware('auth');
Route::get('/templates/{slug}', TemplateShow::class)->name('templates.show');
Route::get('/templates/{slug}/edit', TemplateEdit::class)->name('templates.edit')->middleware('auth');
