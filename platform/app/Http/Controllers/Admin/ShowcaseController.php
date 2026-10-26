<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ShowcaseController extends Controller
{
    public function index()
    {
        return view('livewire.admin.showcase-management');
    }
}
