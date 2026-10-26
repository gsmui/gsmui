<?php

declare(strict_types=1);

namespace App\Domains\Playground\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class PlaygroundIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $language = null;
    public string $sort = 'latest';

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'language' => 'nullable|string|max:50',
        'sort' => 'in:latest,popular,likes',
    ];

    public function render()
    {
        $query = \App\Domains\Playground\Models\Project::where('is_public', true)
            ->with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($this->language) {
            $query->where('language', $this->language);
        }

        $query->when($this->sort === 'popular', fn ($q) => $q->orderByDesc('views_count'))
              ->when($this->sort === 'likes', fn ($q) => $q->orderByDesc('likes_count'))
              ->when($this->sort === 'latest', fn ($q) => $q->latest());

        $projects = $query->paginate(12);

        return view('livewire.playground.index', [
            'projects' => $projects,
        ])->layout('layouts.app');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingLanguage(): void
    {
        $this->resetPage();
    }
}
