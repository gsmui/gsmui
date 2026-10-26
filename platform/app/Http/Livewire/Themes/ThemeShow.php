<?php

declare(strict_types=1);

namespace App\Http\Livewire\Themes;

use Livewire\Component;

class ThemeShow extends Component
{
    public ?\App\Domains\Themes\Models\Theme $theme = null;

    public function mount(string $slug): void
    {
        $this->theme = \App\Domains\Themes\Models\Theme::where('slug', $slug)
            ->where('status', 'published')
            ->with('author', 'variations')
            ->firstOrFail();
    }

    public function recordDownload(): void
    {
        $this->theme->increment('downloads_count');
    }

    public function render()
    {
        return view('livewire.themes.show')->layout('layouts.app');
    }
}
