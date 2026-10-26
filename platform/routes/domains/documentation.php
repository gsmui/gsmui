<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Documentation\DocumentationIndex;
use App\Http\Livewire\Documentation\DocumentationShow;
use App\Http\Livewire\Documentation\DocumentationCreate;
use App\Http\Livewire\Documentation\DocumentationEdit;

// Documentation routes
Route::get('/docs', DocumentationIndex::class)->name('docs.index');
Route::get('/docs/create', DocumentationCreate::class)->name('docs.create')->middleware('auth');
Route::get('/docs/{slug}', DocumentationShow::class)->name('docs.show');
Route::get('/docs/{slug}/edit', DocumentationEdit::class)->name('docs.edit')->middleware('auth');
