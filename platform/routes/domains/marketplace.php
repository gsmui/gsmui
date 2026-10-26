<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Marketplace\MarketplaceIndex;
use App\Http\Livewire\Marketplace\MarketplaceShow;
use App\Http\Livewire\Marketplace\ProductCreate;
use App\Http\Livewire\Marketplace\ProductEdit;

// Marketplace routes
Route::get('/marketplace', MarketplaceIndex::class)->name('marketplace.index');
Route::get('/marketplace/create', ProductCreate::class)->name('marketplace.create')->middleware('auth');
Route::get('/marketplace/{slug}', MarketplaceShow::class)->name('marketplace.show');
Route::get('/marketplace/{slug}/edit', ProductEdit::class)->name('marketplace.edit')->middleware('auth');
