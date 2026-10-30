<?php

declare(strict_types=1);

namespace App\Domains\Documentation\Livewire;

use Livewire\Component;

class DocumentationEdit extends Component
{
    public ?\App\Domains\Documentation\Models\Document $document = null;
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
    public string $status = 'draft';

    protected array $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'body' => 'required|string|max:100000',
        'category' => 'required|string|max:255',
        'subcategory' => 'nullable|string|max:255',
        'version' => 'required|string|max:50',
        'sortOrder' => 'required|integer|min:0',
        'isFeatured' => 'boolean',
        'metaTitle' => 'nullable|string|max:255',
        'metaDescription' => 'nullable|string|max:500',
        'status' => 'in:draft,published,archived',
    ];

    public function mount(string $slug): void
    {
        $this->document = \App\Domains\Documentation\Models\Document::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $this->document->author_id) {
            abort(403);
        }

        $this->title = $this->document->title;
        $this->slug = $this->document->slug;
        $this->body = $this->document->body;
        $this->category = $this->document->category;
        $this->subcategory = $this->document->subcategory;
        $this->version = $this->document->version;
        $this->sortOrder = $this->document->sort_order;
        $this->isFeatured = $this->document->is_featured;
        $this->metaTitle = $this->document->meta_title;
        $this->metaDescription = $this->document->meta_description;
        $this->status = $this->document->status;
    }

    public function save() 
    {
        $this->validate();

        $this->document->update([
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
            'status' => $this->status,
        ]);

        return redirect()->route('docs.show', $this->document->slug)
            ->with('success', 'Document updated successfully!');
    }

    public function delete() 
    {
        if (auth()->id() !== $this->document->author_id) {
            abort(403);
        }

        $this->document->delete();

        return redirect()->route('docs.index')
            ->with('success', 'Document deleted successfully!');
    }

    public function render()
    {
        return view('livewire.documentation.edit')->layout('components.layouts.app');
    }
}
