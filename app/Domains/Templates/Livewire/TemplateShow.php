<?php

declare(strict_types=1);

namespace App\Domains\Templates\Livewire;

use Livewire\Component;

class TemplateShow extends Component
{
    public ?\App\Domains\Templates\Models\Template $template = null;
    public int $rating = 5;
    public string $reviewBody = '';

    protected array $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'reviewBody' => 'required|string|max:1000',
    ];

    public function mount(string $slug): void
    {
        $this->template = \App\Domains\Templates\Models\Template::where('slug', $slug)
            ->with('author', 'category', 'reviews.user')
            ->firstOrFail();
    }

    public function download(): void
    {
        $this->template->increment('downloads_count');
        session()->flash('success', 'Download started!');
    }

    public function addReview() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $this->template->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $this->rating,
            'body' => $this->reviewBody,
        ]);

        $avgRating = $this->template->reviews()->avg('rating');
        $this->template->update([
            'rating' => round($avgRating, 1),
            'rating_count' => $this->template->reviews()->count(),
        ]);

        $this->reviewBody = '';
        $this->rating = 5;
        $this->template->load('reviews.user');
        session()->flash('success', 'Review submitted!');
    }

    public function render()
    {
        return view('livewire.templates.show')->layout('components.layouts.app');
    }
}
