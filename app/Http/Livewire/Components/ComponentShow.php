<?php

declare(strict_types=1);

namespace App\Http\Livewire\Components;

use Livewire\Component;

class ComponentShow extends Component
{
    public ?\App\Domains\Components\Models\Component $component = null;
    public bool $isFavorited = false;

    public function mount(string $slug): void
    {
        $this->component = \App\Domains\Components\Models\Component::where('slug', $slug)
            ->where('status', 'published')
            ->with('author', 'reviews.user')
            ->firstOrFail();

        if (auth()->check()) {
            $this->isFavorited = auth()->user()->favorites()
                ->where('component_id', $this->component->id)
                ->exists();
        }
    }

    public function toggleFavorite()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($this->isFavorited) {
            auth()->user()->favorites()->detach($this->component->id);
            $this->isFavorited = false;
        } else {
            auth()->user()->favorites()->attach($this->component->id);
            $this->isFavorited = true;
        }
    }

    public function recordDownload(): void
    {
        $this->component->increment('downloads_count');
    }

    public function render()
    {
        return view('livewire.components.show')->layout('components.layouts.app');
    }
}
