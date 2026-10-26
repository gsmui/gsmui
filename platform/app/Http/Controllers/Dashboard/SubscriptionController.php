<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('livewire.dashboard.subscription');
    }
}
