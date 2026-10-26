<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class ApiKeyController extends Controller
{
    public function index()
    {
        return view('livewire.dashboard.api-key-management');
    }
}
