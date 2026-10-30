<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class NotificationsIndex extends Component
{
    public function render()
    {
        $notifications = auth()->user()->notifications()->paginate(20);

        return view('livewire.dashboard.notifications.index', [
            'notifications' => $notifications,
        ])->layout('components.layouts.app');
    }
}
