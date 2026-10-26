<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function index()
    {
        return view('livewire.dashboard.favorites');
    }
}
