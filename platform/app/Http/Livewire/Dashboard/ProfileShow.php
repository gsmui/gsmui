<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class ProfileShow extends Component
{
    public function render()
    {
        $user = auth()->user();

        return view('livewire.dashboard.profile.show', [
            'user' => $user,
            'profile' => $user->profile,
        ])->layout('layouts.app');
    }
}
