<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    public function index()
    {
        return view('livewire.admin.template-management');
    }
}
