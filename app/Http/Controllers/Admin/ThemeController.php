<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function index()
    {
        return view('livewire.admin.theme-management');
    }
}
