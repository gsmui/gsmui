<?php

declare(strict_types=1);

namespace App\Domains\Themes\Livewire;

use Livewire\Component;

class ThemeShow extends Component
{
    public ?\App\Domains\Themes\Models\Theme $theme = null;
    public ?string $selectedVariation = null;

    public function mount(string $slug): void
    {
        $this->theme = \App\Domains\Themes\Models\Theme::where('slug', $slug)
            ->where('status', 'published')
            ->with('author', 'variations')
            ->firstOrFail();

        if ($this->theme->variations->isNotEmpty()) {
            $this->selectedVariation = $this->theme->variations->first()->id;
        }
    }

    public function selectVariation(int $variationId): void
    {
        $this->selectedVariation = $variationId;
    }

    public function recordDownload(): void
    {
        $this->theme->increment('downloads_count');

        \App\Domains\Themes\Models\ThemeDownload::create([
            'theme_id' => $this->theme->id,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.themes.show')->layout('layouts.app');
    }
}
