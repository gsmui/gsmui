<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class MarketplaceIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';
    public string $sort = 'latest';
    public ?string $priceRange = null;

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'type' => 'nullable|string|max:50',
        'sort' => 'in:latest,popular,price_asc,price_desc',
        'priceRange' => 'nullable|in:free,paid',
    ];

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

        if ($this->priceRange === 'free') {
            $query->where('price', 0);
        } elseif ($this->priceRange === 'paid') {
            $query->where('price', '>', 0);
        }

        $query->when($this->sort === 'popular', fn ($q) => $q->orderByDesc('downloads_count'))
              ->when($this->sort === 'price_asc', fn ($q) => $q->orderBy('price'))
              ->when($this->sort === 'price_desc', fn ($q) => $q->orderByDesc('price'))
              ->when($this->sort === 'latest', fn ($q) => $q->latest());

        $products = $query->paginate(12);

        return view('livewire.marketplace.index', [
            'products' => $products,
        ])->layout('layouts.app');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingType(): void
    {
        $this->resetPage();
    }
}
