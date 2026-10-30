<?php

declare(strict_types=1);

namespace App\Domains\Themes\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ThemeIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';
    public string $sort = 'latest';

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'type' => 'nullable|in:free,premium',
        'sort' => 'in:latest,popular,downloads',
    ];

    public function render()
    {
        $query = \App\Domains\Themes\Models\Theme::where('status', 'published')
            ->with('author');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($this->type === 'free') {
            $query->where('is_free', true);
        } elseif ($this->type === 'premium') {
            $query->where('is_premium', true);
        }

        $query->when($this->sort === 'popular', fn ($q) => $q->orderByDesc('rating'))
              ->when($this->sort === 'downloads', fn ($q) => $q->orderByDesc('downloads_count'))
              ->when($this->sort === 'latest', fn ($q) => $q->latest());

        $themes = $query->paginate(12);

        return view('livewire.themes.index', [
            'themes' => $themes,
        ])->layout('components.layouts.app');
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
