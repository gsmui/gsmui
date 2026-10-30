<?php

declare(strict_types=1);

namespace App\Domains\Showcase\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ShowcaseIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $tag = null;
    public string $sort = 'latest';

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'tag' => 'nullable|string|max:100',
        'sort' => 'in:latest,popular,likes',
    ];

    public function render()
    {
        $query = \App\Domains\Showcase\Models\ShowcaseItem::where('status', 'published')
            ->with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($this->tag) {
            $query->whereJsonContains('tags', $this->tag);
        }

        $query->when($this->sort === 'popular', fn ($q) => $q->orderByDesc('views_count'))
              ->when($this->sort === 'likes', fn ($q) => $q->orderByDesc('likes_count'))
              ->when($this->sort === 'latest', fn ($q) => $q->latest());

        $items = $query->paginate(12);

        return view('livewire.showcase.index', [
            'items' => $items,
        ])->layout('components.layouts.app');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTag(): void
    {
        $this->resetPage();
    }
}
