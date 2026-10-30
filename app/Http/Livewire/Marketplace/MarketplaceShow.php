<?php

declare(strict_types=1);

namespace App\Http\Livewire\Marketplace;

use Livewire\Component;
use App\Models\MarketplaceProduct;

class MarketplaceShow extends Component
{
    public ?MarketplaceProduct $product = null;

    public function mount(string $slug): void
    {
        $this->product = MarketplaceProduct::where('slug', $slug)
            ->with('author', 'reviews.user')
            ->firstOrFail();
    }

    public function purchase()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Purchase logic
        session()->flash('success', 'Purchase initiated!');
    }

    public function render()
    {
        return view('livewire.marketplace.show')->layout('components.layouts.app');
    }
}
