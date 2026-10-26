<?php

declare(strict_types=1);

namespace App\Domains\Showcase\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ShowcaseCreate extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $slug = '';
    public string $description = '';
    public string $url = '';
    public ?string $screenshot = null;
    public ?array $tags = null;

    protected array $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:showcase_items,slug',
        'description' => 'required|string|max:5000',
        'url' => 'required|url|max:500',
        'screenshot' => 'nullable|string|max:500',
        'tags' => 'nullable|array',
    ];

    public function updatedTitle(): void
    {
        if (empty($this->slug)) {
            $this->slug = \Illuminate\Support\Str::slug($this->title);
        }
    }

    public function save(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $item = \App\Domains\Showcase\Models\ShowcaseItem::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'url' => $this->url,
            'screenshot' => $this->screenshot,
            'tags' => $this->tags,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return redirect()->route('showcase.show', $item->slug)
            ->with('success', 'Showcase item submitted for review!');
    }

    public function render()
    {
        return view('livewire.showcase.create')->layout('layouts.app');
    }
}
