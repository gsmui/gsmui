<?php

declare(strict_types=1);

namespace App\Domains\Charts\Livewire;

use Livewire\Component;

class ChartShow extends Component
{
    public ?\App\Domains\Charts\Models\Chart $chart = null;

    public function mount(string $slug): void
    {
        $this->chart = \App\Domains\Charts\Models\Chart::where('slug', $slug)
            ->where('is_public', true)
            ->with('user')
            ->firstOrFail();

        $this->chart->increment('views_count');
    }

    public function toggleFavorite() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $favorite = \App\Domains\Charts\Models\ChartFavorite::where('user_id', auth()->id())
            ->where('chart_id', $this->chart->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            \App\Domains\Charts\Models\ChartFavorite::create([
                'user_id' => auth()->id(),
                'chart_id' => $this->chart->id,
            ]);
        }

        session()->flash('success', 'Favorite toggled!');
    }

    public function fork() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $forkedChart = \App\Domains\Charts\Models\Chart::create([
            'user_id' => auth()->id(),
            'name' => $this->chart->name . ' (Fork)',
            'slug' => \Illuminate\Support\Str::slug($this->chart->name . '-fork-' . uniqid()),
            'type' => $this->chart->type,
            'data' => $this->chart->data,
            'config' => $this->chart->config,
            'is_public' => false,
        ]);

        return redirect()->route('charts.show', $forkedChart->slug)
            ->with('success', 'Chart forked successfully!');
    }

    public function render()
    {
        return view('livewire.charts.show')->layout('components.layouts.app');
    }
}
