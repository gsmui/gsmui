<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Livewire;

use Livewire\Component;

class MarketplaceShow extends Component
{
    public ?\App\Domains\Marketplace\Models\Product $product = null;
    public int $rating = 5;
    public string $reviewBody = '';

    protected array $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'reviewBody' => 'required|string|max:1000',
    ];

    public function mount(string $slug): void
    {
        $this->product = \App\Domains\Marketplace\Models\Product::where('slug', $slug)
            ->with('author', 'reviews.user')
            ->firstOrFail();
    }

    public function purchase() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        session()->flash('success', 'Purchase initiated!');
    }

    public function addReview() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $this->product->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $this->rating,
            'body' => $this->reviewBody,
        ]);

        $avgRating = $this->product->reviews()->avg('rating');
        $this->product->update([
            'rating' => round($avgRating, 1),
            'rating_count' => $this->product->reviews()->count(),
        ]);

        $this->reviewBody = '';
        $this->rating = 5;
        $this->product->load('reviews.user');
        session()->flash('success', 'Review submitted!');
    }

    public function toggleFavorite() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        session()->flash('success', 'Favorite toggled!');
    }

    public function render()
    {
        return view('livewire.marketplace.show')->layout('components.layouts.app');
    }
}
