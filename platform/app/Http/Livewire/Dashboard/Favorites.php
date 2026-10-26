<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Favorites extends Component
{
    public function getFavorites() { return auth()->user()->favorites()->latest()->get(); }
    public function removeFavorite($componentId) { auth()->user()->favorites()->detach($componentId); session()->flash('success', 'Removed from favorites.'); }

    public function render()
    {
        return view('livewire.dashboard.favorites', ['favorites' => $this->getFavorites()])->layout('layouts.dashboard', ['title' => 'Favorites']);
    }
}
