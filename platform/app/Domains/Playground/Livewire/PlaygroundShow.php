<?php

declare(strict_types=1);

namespace App\Domains\Playground\Livewire;

use Livewire\Component;

class PlaygroundShow extends Component
{
    public ?\App\Domains\Playground\Models\Project $project = null;
    public string $code = '';
    public ?string $output = null;
    public bool $isRunning = false;

    public function mount(string $slug): void
    {
        $this->project = \App\Domains\Playground\Models\Project::where('slug', $slug)
            ->where('is_public', true)
            ->with('user')
            ->firstOrFail();

        $this->project->increment('views_count');
        $this->code = $this->project->code;
    }

    public function updateCode(string $code): void
    {
        $this->code = $code;
    }

    public function saveCode(): void
    {
        if (!auth()->check() || auth()->id() !== $this->project->user_id) {
            return;
        }

        $this->project->update(['code' => $this->code]);
        session()->flash('success', 'Code saved!');
    }

    public function runCode(): void
    {
        $this->isRunning = true;
        $this->output = null;

        try {
            $this->project->update([
                'code' => $this->code,
                'last_run_at' => now(),
            ]);

            $this->output = 'Code executed successfully.';
        } catch (\Exception $e) {
            $this->output = 'Error: ' . $e->getMessage();
        } finally {
            $this->isRunning = false;
        }
    }

    public function fork(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $forkedProject = \App\Domains\Playground\Models\Project::create([
            'user_id' => auth()->id(),
            'name' => $this->project->name . ' (Fork)',
            'slug' => \Illuminate\Support\Str::slug($this->project->name . '-fork-' . uniqid()),
            'description' => $this->project->description,
            'code' => $this->project->code,
            'language' => $this->project->language,
            'framework' => $this->project->framework,
            'is_public' => false,
            'forked_from' => $this->project->id,
        ]);

        return redirect()->route('playground.show', $forkedProject->slug)
            ->with('success', 'Project forked successfully!');
    }

    public function toggleLike(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        session()->flash('success', 'Like toggled!');
    }

    public function render()
    {
        return view('livewire.playground.show')->layout('layouts.app');
    }
}
