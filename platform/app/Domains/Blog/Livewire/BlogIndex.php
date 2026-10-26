<?php

declare(strict_types=1);

namespace App\Domains\Blog\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $category = null;
    public string $sort = 'latest';

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'category' => 'nullable|integer|exists:post_categories,id',
        'sort' => 'in:latest,oldest,popular',
    ];

    public function render()
    {
        $query = \App\Domains\Blog\Models\Post::where('status', 'published')
            ->with('author', 'category');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('body', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        $query->when($this->sort === 'oldest', fn ($q) => $q->oldest('published_at'))
              ->when($this->sort === 'popular', fn ($q) => $q->orderByDesc('views_count'))
              ->when($this->sort === 'latest', fn ($q) => $q->latest('published_at'));

        $posts = $query->paginate(10);

        return view('livewire.blog.index', [
            'posts' => $posts,
            'categories' => \App\Domains\Blog\Models\PostCategory::orderBy('name')->get(),
        ])->layout('layouts.app');
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
}
