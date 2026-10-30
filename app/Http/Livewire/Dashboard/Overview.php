<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Overview extends Component
{
    public $user, $recentProjects, $favoriteCount, $downloadCount, $projectCount;

    public function mount()
    {
        $this->user = auth()->user();
        $this->recentProjects = $this->user->projects()->latest()->take(5)->get();
        $this->favoriteCount = $this->user->favorites()->count();
        $this->downloadCount = 0;
        $this->projectCount = $this->user->projects()->count();
    }

    public function render()
    {
        return view('livewire.dashboard.overview')->layout('components.layouts.dashboard', ['title' => 'Dashboard']);
    }
}
