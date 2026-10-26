<?php

declare(strict_types=1);

namespace App\Domains\Blog\Livewire;

use Livewire\Component;

class BlogShow extends Component
{
    public ?\App\Domains\Blog\Models\Post $post = null;
    public string $commentBody = '';

    protected array $rules = [
        'commentBody' => 'required|string|max:1000',
    ];

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

        $this->validate();

        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->commentBody,
        ]);

        $this->commentBody = '';
        $this->post->load('comments.user');
        session()->flash('success', 'Comment added!');
    }

    public function toggleLike(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $like = \App\Domains\Blog\Models\PostLike::where('user_id', auth()->id())
            ->where('post_id', $this->post->id)
            ->first();

        if ($like) {
            $like->delete();
            $this->post->decrement('likes_count');
        } else {
            \App\Domains\Blog\Models\PostLike::create([
                'user_id' => auth()->id(),
                'post_id' => $this->post->id,
            ]);
            $this->post->increment('likes_count');
        }
    }

    public function render()
    {
        return view('livewire.blog.show')->layout('layouts.app');
    }
}
