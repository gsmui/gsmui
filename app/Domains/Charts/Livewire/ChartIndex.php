<?php

declare(strict_types=1);

namespace App\Domains\Charts\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ChartIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $type = null;
    public string $sort = 'latest';

    protected array $rules = [
        'search' => 'nullable|string|max:255',
        'type' => 'nullable|string|max:50',
        'sort' => 'in:latest,popular',
    ];

    public function render()
    {
        $query = \App\Domains\Charts\Models\Chart::where('is_public', true)
            ->with('user');

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        $query->when($this->sort === 'popular', fn ($q) => $q->orderByDesc('views_count'))
              ->when($this->sort === 'latest', fn ($q) => $q->latest());

        $charts = $query->paginate(12);

        return view('livewire.charts.index', [
            'charts' => $charts,
        ])->layout('components.layouts.app');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
}
