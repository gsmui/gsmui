<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn ($request) => $request->user());
});

Route::get('/components', fn () => response()->json(\App\Domains\Components\Models\Component::all()));
Route::get('/templates', fn () => response()->json(\App\Domains\Templates\Models\Template::all()));
Route::get('/themes', fn () => response()->json(\App\Domains\Themes\Models\Theme::all()));
Route::get('/posts', fn () => response()->json(\App\Domains\Blog\Models\Post::published()->get()));
