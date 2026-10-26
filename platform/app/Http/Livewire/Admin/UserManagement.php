<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';

    public function getUsers()
    {
        $query = User::query();
        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%");
        }
        return $query->latest()->paginate(20);
    }

    public function toggleAdmin(User $user)
    {
        if ($user->hasRole('admin')) { $user->removeRole('admin'); } else { $user->assignRole('admin'); }
        session()->flash('success', 'User role updated.');
    }

    public function deleteUser(User $user) { $user->delete(); session()->flash('success', 'User deleted.'); }

    public function render()
    {
        return view('livewire.admin.user-management', ['users' => $this->getUsers()])->layout('layouts.admin', ['title' => 'User Management']);
    }
}
