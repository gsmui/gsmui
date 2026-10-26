<?php

declare(strict_types=1);

namespace App\Http\Livewire\Blog;

use Livewire\Component;

class BlogShow extends Component
{
    public ?\App\Domains\Blog\Models\Post $post = null;
    public string $commentBody = '';

    public function mount(string $slug): void
    {
        $this->post = \App\Domains\Blog\Models\Post::where('slug', $slug)
            ->where('status', 'published')
            ->with('author', 'category', 'comments.user')
            ->firstOrFail();

        $this->post->increment('views_count');
    }

    public function addComment(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate(['commentBody' => 'required|string|max:1000']);

        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->commentBody,
        ]);

        $this->commentBody = '';
        session()->flash('success', 'Comment added!');
    }

    public function render()
    {
        return view('livewire.blog.show')->layout('layouts.app');
    }
}
