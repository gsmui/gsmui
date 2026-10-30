<?php

declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class UserShow extends Component
{
    public ?\App\Domains\Users\Models\User $user = null;

    public function mount(int $user): void
    {
        $this->user = \App\Domains\Users\Models\User::findOrFail($user);
    }

    public function updateRole(string $role): void
    {
        $this->user->syncRoles([$role]);
        session()->flash('success', 'User role updated!');
    }

    public function render()
    {
        return view('livewire.admin.users.show', [
            'user' => $this->user,
        ])->layout('components.layouts.app');
    }
}
