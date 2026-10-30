<?php

declare(strict_types=1);

namespace App\Domains\Documentation\Livewire;

use Livewire\Component;

class DocumentationCreate extends Component
{
    public string $title = '';
    public string $slug = '';
    public string $body = '';
    public string $category = '';
    public ?string $subcategory = null;
    public string $version = '1.0';
    public int $sortOrder = 0;
    public bool $isFeatured = false;
    public ?string $metaTitle = null;
    public ?string $metaDescription = null;

    protected array $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:documents,slug',
        'body' => 'required|string|max:100000',
        'category' => 'required|string|max:255',
        'subcategory' => 'nullable|string|max:255',
        'version' => 'required|string|max:50',
        'sortOrder' => 'required|integer|min:0',
        'isFeatured' => 'boolean',
        'metaTitle' => 'nullable|string|max:255',
        'metaDescription' => 'nullable|string|max:500',
    ];

    public function updatedTitle(): void
    {
        if (empty($this->slug)) {
            $this->slug = \Illuminate\Support\Str::slug($this->title);
        }
    }

    public function save() 
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $document = \App\Domains\Documentation\Models\Document::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'category' => $this->category,
            'subcategory' => $this->subcategory,
            'version' => $this->version,
            'sort_order' => $this->sortOrder,
            'is_featured' => $this->isFeatured,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'author_id' => auth()->id(),
            'status' => 'draft',
        ]);

        return redirect()->route('docs.show', $document->slug)
            ->with('success', 'Document created successfully!');
    }

    public function render()
    {
        return view('livewire.documentation.create')->layout('components.layouts.app');
    }
}
