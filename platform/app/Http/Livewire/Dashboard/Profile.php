<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Profile extends Component
{
    public $user, $name, $email, $username, $bio, $website;

    public function mount()
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->username = $this->user->username;
        $this->bio = $this->user->bio;
        $this->website = $this->user->website;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $this->user->id,
        ]);

        $this->user->update([
            'name' => $this->name, 'email' => $this->email,
            'username' => $this->username, 'bio' => $this->bio, 'website' => $this->website,
        ]);

        session()->flash('success', 'Profile updated.');
    }

    public function render()
    {
        return view('livewire.dashboard.profile')->layout('layouts.dashboard', ['title' => 'Profile']);
    }
}
