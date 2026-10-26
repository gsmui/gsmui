<?php

declare(strict_types=1);

namespace App\Http\Livewire\Marketplace;

use Livewire\Component;
use Livewire\WithPagination;

class MarketplaceIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';

    public function render()
    {
        $query = \App\Domains\Marketplace\Models\Product::with('author');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        $products = $query->latest()->paginate(12);

        return view('livewire.marketplace.index', [
            'products' => $products,
        ])->layout('layouts.app');
    }
}
