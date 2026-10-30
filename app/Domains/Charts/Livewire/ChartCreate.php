<?php

declare(strict_types=1);

namespace App\Domains\Charts\Livewire;

use Livewire\Component;

class ChartCreate extends Component
{
    public string $name = '';
    public string $type = 'bar';
    public array $data = [];
    public array $config = [];
    public bool $isPublic = true;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|in:bar,line,pie,doughnut,area,radar,scatter',
        'data' => 'required|array|min:1',
        'config' => 'nullable|array',
        'isPublic' => 'boolean',
    ];

    protected array $validationAttributes = [
        'name' => 'chart name',
        'type' => 'chart type',
        'data' => 'chart data',
    ];

    public function mount(): void
    {
        $this->data = [
            ['label' => 'Dataset 1', 'values' => [10, 20, 30, 40, 50]],
        ];
        $this->config = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            'colors' => ['#4F46E5', '#10B981', '#F59E0B'],
        ];
    }

    public function addDataset(): void
    {
        $this->data[] = ['label' => 'Dataset ' . (count($this->data) + 1), 'values' => []];
    }

    public function removeDataset(int $index): void
    {
        unset($this->data[$index]);
        $this->data = array_values($this->data);
    }

    public function save() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $chart = \App\Domains\Charts\Models\Chart::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'slug' => \Illuminate\Support\Str::slug($this->name),
            'type' => $this->type,
            'data' => $this->data,
            'config' => $this->config,
            'is_public' => $this->isPublic,
        ]);

        return redirect()->route('charts.show', $chart->slug)
            ->with('success', 'Chart created successfully!');
    }

    public function render()
    {
        return view('livewire.charts.create')->layout('components.layouts.app');
    }
}
