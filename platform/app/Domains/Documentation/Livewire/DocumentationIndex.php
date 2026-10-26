<?php

declare(strict_types=1);

namespace App\Domains\Documentation\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class DocumentationIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $category = null;

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'category' => 'nullable|string|max:255',
    ];

    public function render()
    {
        $query = \App\Domains\Documentation\Models\Document::where('status', 'published')
            ->with('author');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('body', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        $documents = $query->orderBy('sort_order')->paginate(20);

        return view('livewire.documentation.index', [
            'documents' => $documents,
            'categories' => \App\Domains\Documentation\Models\Document::select('category')
                ->where('status', 'published')
                ->distinct()
                ->pluck('category'),
        ])->layout('layouts.app');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }
}
