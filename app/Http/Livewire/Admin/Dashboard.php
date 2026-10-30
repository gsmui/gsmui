<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Domains\Users\Models\User;
use App\Domains\Components\Models\Component as ComponentModel;
use App\Domains\Templates\Models\Template;
use App\Domains\Blog\Models\Post;

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
        return view('livewire.admin.dashboard')->layout('components.layouts.admin', ['title' => 'Admin Dashboard']);
    }
}
