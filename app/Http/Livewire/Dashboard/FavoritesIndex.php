<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;

class FavoritesIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $favorites = auth()->user()->favorites()->paginate(12);

        return view('livewire.dashboard.favorites.index', [
            'favorites' => $favorites,
        ])->layout('components.layouts.app');
    }
}
