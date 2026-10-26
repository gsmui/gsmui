<?php

declare(strict_types=1);

namespace App\Domains\Showcase\Livewire;

use Livewire\Component;

class ShowcaseShow extends Component
{
    public ?\App\Domains\Showcase\Models\ShowcaseItem $item = null;
    public string $commentBody = '';

    protected array $rules = [
        'commentBody' => 'required|string|max:1000',
    ];

    public function mount(string $slug): void
    {
        $this->item = \App\Domains\Showcase\Models\ShowcaseItem::where('slug', $slug)
            ->where('status', 'published')
            ->with('user', 'comments.user')
            ->firstOrFail();

        $this->item->increment('views_count');
    }

    public function toggleLike(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $like = \App\Domains\Showcase\Models\ShowcaseLike::where('user_id', auth()->id())
            ->where('showcase_item_id', $this->item->id)
            ->first();

        if ($like) {
            $like->delete();
            $this->item->decrement('likes_count');
        } else {
            \App\Domains\Showcase\Models\ShowcaseLike::create([
                'user_id' => auth()->id(),
                'showcase_item_id' => $this->item->id,
            ]);
            $this->item->increment('likes_count');
        }
    }

    public function addComment(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $this->item->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->commentBody,
        ]);

        $this->commentBody = '';
        $this->item->load('comments.user');
        session()->flash('success', 'Comment added!');
    }

    public function render()
    {
        return view('livewire.showcase.show')->layout('layouts.app');
    }
}
