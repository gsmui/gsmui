<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('pages.admin.settings');
    }

    public function update(Request $request)
    {
        // Save settings
        session()->flash('success', 'Settings updated successfully.');
        return redirect()->route('admin.settings');
    }
}
