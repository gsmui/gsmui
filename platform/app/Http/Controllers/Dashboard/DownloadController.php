<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        return view('livewire.dashboard.downloads');
    }
}
