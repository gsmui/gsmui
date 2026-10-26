<?php

declare(strict_types=1);

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $role = '';

    public function render()
    {
        $query = \App\Domains\Users\Models\User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%")
                  ->orWhere('username', 'like', "%{$this->search}%");
            });
        }

        if ($this->role) {
            $query->role($this->role);
        }

        $users = $query->latest()->paginate(20);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ])->layout('layouts.app');
    }
}
