<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.dashboard.index', [
            'favorites' => $user->favorites()->latest()->take(5)->get(),
            'projects' => $user->projects()->latest()->take(5)->get(),
            'notifications' => $user->notifications()->unread()->take(5)->get(),
        ])->layout('components.layouts.app');
    }
}
