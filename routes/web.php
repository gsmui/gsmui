<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComponentController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/components', [ComponentController::class, 'index'])->name('components.index');
Route::get('/components/{component}', [ComponentController::class, 'show'])->name('components.show');

Route::get('/about', fn () => view('pages.marketing.about'))->name('about');
Route::get('/pricing', fn () => view('pages.marketing.pricing'))->name('pricing');
Route::get('/docs', fn () => view('pages.docs.index'))->name('docs.index');
Route::get('/blog', fn () => view('pages.marketing.blog'))->name('blog');
Route::get('/showcase', fn () => view('pages.marketing.showcase'))->name('showcase');
Route::get('/playground', fn () => view('pages.marketing.playground'))->name('playground');
Route::get('/privacy', fn () => view('pages.marketing.privacy'))->name('privacy');
Route::get('/terms', fn () => view('pages.marketing.terms'))->name('terms');
