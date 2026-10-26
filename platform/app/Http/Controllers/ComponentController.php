<?php

namespace App\Http\Controllers;

use App\Models\Component;

class ComponentController extends Controller
{
    public function index()
    {
        $components = Component::where('status', 'active')->latest()->paginate(20);
        return view('pages.marketing.components.index', compact('components'));
    }

    public function show(Component $component)
    {
        return view('pages.marketing.components.show', compact('component'));
    }
}
