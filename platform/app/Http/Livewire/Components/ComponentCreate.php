<?php

declare(strict_types=1);

namespace App\Http\Livewire\Components;

use Livewire\Component;

class ComponentCreate extends Component
{
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public string $category = '';
    public ?string $subcategory = null;
    public string $version = '1.0.0';
    public bool $isFree = true;
    public bool $isPremium = false;
    public ?float $price = null;
    public ?string $codeExample = null;
    public ?string $installationGuide = null;
    public ?string $propsDocumentation = null;
    public ?string $eventsDocumentation = null;
    public ?string $slotsDocumentation = null;
    public ?string $accessibilityNotes = null;
    public ?array $tags = null;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:components,slug',
        'description' => 'required|string|max:5000',
        'category' => 'required|string|max:255',
        'subcategory' => 'nullable|string|max:255',
        'version' => 'required|string|max:50',
        'isFree' => 'boolean',
        'isPremium' => 'boolean',
        'price' => 'nullable|numeric|min:0',
        'codeExample' => 'nullable|string',
        'installationGuide' => 'nullable|string',
        'propsDocumentation' => 'nullable|string',
        'eventsDocumentation' => 'nullable|string',
        'slotsDocumentation' => 'nullable|string',
        'accessibilityNotes' => 'nullable|string',
        'tags' => 'nullable|array',
    ];

    public function updatedName(): void
    {
        if (empty($this->slug)) {
            $this->slug = \Illuminate\Support\Str::slug($this->name);
        }
    }

    public function create(): void
    {
        $this->validate();

        $component = \App\Domains\Components\Models\Component::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'version' => $this->version,
            'is_free' => $this->isFree,
            'is_premium' => $this->isPremium,
            'price' => $this->price,
            'code_example' => $this->codeExample,
            'installation_guide' => $this->installationGuide,
            'props_documentation' => $this->propsDocumentation,
            'events_documentation' => $this->eventsDocumentation,
            'slots_documentation' => $this->slotsDocumentation,
            'accessibility_notes' => $this->accessibilityNotes,
            'tags' => $this->tags,
            'author_id' => auth()->id(),
            'status' => 'draft',
        ]);

        return redirect()->route('components.show', $component->slug)
            ->with('success', 'Component created successfully!');
    }

    public function render()
    {
        return view('livewire.components.create')->layout('layouts.app');
    }
}
