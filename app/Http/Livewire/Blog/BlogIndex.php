<?php

declare(strict_types=1);

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $category = null;

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

        $posts = $query->latest('published_at')->paginate(10);

        return view('livewire.blog.index', [
            'posts' => $posts,
            'categories' => \App\Domains\Blog\Models\PostCategory::orderBy('name')->get(),
        ])->layout('components.layouts.app');
    }
}
