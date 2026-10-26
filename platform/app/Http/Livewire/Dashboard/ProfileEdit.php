<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class ProfileEdit extends Component
{
    public string $name = '';
    public string $bio = '';
    public string $location = '';
    public string $company = '';
    public string $website = '';
    public string $github_username = '';
    public string $twitter_username = '';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'bio' => 'nullable|string|max:500',
        'location' => 'nullable|string|max:255',
        'company' => 'nullable|string|max:255',
        'website' => 'nullable|url',
        'github_username' => 'nullable|string|max:255',
        'twitter_username' => 'nullable|string|max:255',
    ];

    public function mount(): void
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->bio = $user->bio ?? '';
        $this->location = $user->profile?->location ?? '';
        $this->company = $user->profile?->company ?? '';
        $this->website = $user->website ?? '';
        $this->github_username = $user->github_username ?? '';
        $this->twitter_username = $user->twitter_username ?? '';
    }

    public function updateProfile(): void
    {
        $this->validate();

        $user = auth()->user();

        $user->update([
            'name' => $this->name,
            'bio' => $this->bio,
            'website' => $this->website,
            'github_username' => $this->github_username,
            'twitter_username' => $this->twitter_username,
        ]);

        $user->profile()->updateOrCreate(['user_id' => $user->id], [
            'location' => $this->location,
            'company' => $this->company,
        ]);

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.dashboard.profile.edit')->layout('layouts.app');
    }
}
