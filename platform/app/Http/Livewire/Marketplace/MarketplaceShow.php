<?php

declare(strict_types=1);

namespace App\Http\Livewire\Marketplace;

use Livewire\Component;

class MarketplaceShow extends Component
{
    public ?\App\Domains\Marketplace\Models\Product $product = null;

    public function mount(string $slug): void
    {
        $this->product = \App\Domains\Marketplace\Models\Product::where('slug', $slug)
            ->with('author', 'reviews.user')
            ->firstOrFail();
    }

    public function purchase(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Purchase logic
        session()->flash('success', 'Purchase initiated!');
    }

    public function render()
    {
        return view('livewire.marketplace.show')->layout('layouts.app');
    }
}
