<?php

declare(strict_types=1);

namespace App\Domains\Templates\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class TemplateCreate extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public ?int $categoryId = null;
    public bool $isFree = true;
    public bool $isPremium = false;
    public ?float $price = null;
    public ?string $previewImage = null;
    public ?string $demoUrl = null;
    public ?string $downloadUrl = null;
    public string $version = '1.0.0';
    public ?string $framework = null;
    public ?string $industry = null;
    public ?array $tags = null;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:templates,slug',
        'description' => 'required|string|max:10000',
        'categoryId' => 'nullable|integer|exists:template_categories,id',
        'isFree' => 'boolean',
        'isPremium' => 'boolean',
        'price' => 'nullable|numeric|min:0',
        'previewImage' => 'nullable|string|max:500',
        'demoUrl' => 'nullable|url|max:500',
        'downloadUrl' => 'nullable|string|max:500',
        'version' => 'required|string|max:50',
        'framework' => 'nullable|string|max:100',
        'industry' => 'nullable|string|max:100',
        'tags' => 'nullable|array',
    ];

    public function updatedName(): void
    {
        if (empty($this->slug)) {
            $this->slug = \Illuminate\Support\Str::slug($this->name);
        }
    }

    public function save() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $template = \App\Domains\Templates\Models\Template::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'is_free' => $this->isFree,
            'is_premium' => $this->isPremium,
            'price' => $this->price,
            'preview_image' => $this->previewImage,
            'demo_url' => $this->demoUrl,
            'download_url' => $this->downloadUrl,
            'version' => $this->version,
            'framework' => $this->framework,
            'industry' => $this->industry,
            'tags' => $this->tags,
            'author_id' => auth()->id(),
            'status' => 'draft',
        ]);

        return redirect()->route('templates.show', $template->slug)
            ->with('success', 'Template submitted successfully!');
    }

    public function render()
    {
        return view('livewire.templates.create', [
            'categories' => \App\Domains\Templates\Models\TemplateCategory::orderBy('name')->get(),
        ])->layout('components.layouts.app');
    }
}
