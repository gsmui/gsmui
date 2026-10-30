<?php

declare(strict_types=1);

namespace App\Domains\Templates\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class TemplateIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $category = null;
    public string $type = '';
    public string $sort = 'latest';

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'category' => 'nullable|integer|exists:template_categories,id',
        'type' => 'nullable|in:free,premium',
        'sort' => 'in:latest,popular,rating',
    ];

    public function render()
    {
        $query = \App\Domains\Templates\Models\Template::with('author', 'category');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->type === 'free') {
            $query->where('is_free', true);
        } elseif ($this->type === 'premium') {
            $query->where('is_premium', true);
        }

        $query->when($this->sort === 'popular', fn ($q) => $q->orderByDesc('downloads_count'))
              ->when($this->sort === 'rating', fn ($q) => $q->orderByDesc('rating'))
              ->when($this->sort === 'latest', fn ($q) => $q->latest());

        $templates = $query->paginate(12);

        return view('livewire.templates.index', [
            'templates' => $templates,
            'categories' => \App\Domains\Templates\Models\TemplateCategory::orderBy('name')->get(),
        ])->layout('components.layouts.app');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }
}
