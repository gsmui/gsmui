<?php

declare(strict_types=1);

namespace App\Http\Livewire\Themes;

use Livewire\Component;
use Livewire\WithPagination;

class ThemeIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $type = '';

    public function render()
    {
        $query = \App\Domains\Themes\Models\Theme::where('status', 'published')
            ->with('author');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($this->type === 'free') {
            $query->where('is_free', true);
        } elseif ($this->type === 'premium') {
            $query->where('is_premium', true);
        }

        $themes = $query->latest()->paginate(12);

        return view('livewire.themes.index', [
            'themes' => $themes,
        ])->layout('components.layouts.app');
    }
}
