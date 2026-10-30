<?php

declare(strict_types=1);

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;

class ComponentIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $category = '';
    public string $type = '';

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'category' => 'nullable|string|max:255',
        'type' => 'nullable|in:all,free,premium',
    ];

    public function render()
    {
        $query = \App\Domains\Components\Models\Component::query()
            ->where('status', 'published');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhere('tags', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->type === 'free') {
            $query->where('is_free', true);
        } elseif ($this->type === 'premium') {
            $query->where('is_premium', true);
        }

        $components = $query->latest()->paginate(12);

        return view('livewire.components.index', [
            'components' => $components,
            'categories' => \App\Domains\Components\Models\ComponentCategory::orderBy('sort_order')->get(),
        ])->layout('components.layouts.app');
    }
}
