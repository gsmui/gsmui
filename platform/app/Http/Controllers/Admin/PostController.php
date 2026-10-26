<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        return view('livewire.admin.post-management');
    }
}
