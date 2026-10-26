<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Component as ComponentModel;
use App\Models\Template;
use App\Models\Post;

class Dashboard extends Component
{
    public $totalUsers, $totalComponents, $totalTemplates, $totalPosts;
    public $recentUsers, $recentComponents;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->totalComponents = ComponentModel::count();
        $this->totalTemplates = Template::count();
        $this->totalPosts = Post::count();
        $this->recentUsers = User::latest()->take(5)->get();
        $this->recentComponents = ComponentModel::latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.admin', ['title' => 'Admin Dashboard']);
    }
}
