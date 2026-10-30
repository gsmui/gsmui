<?php

declare(strict_types=1);

namespace App\Domains\Documentation\Livewire;

use Livewire\Component;

class DocumentationShow extends Component
{
    public ?\App\Domains\Documentation\Models\Document $document = null;
    public ?string $activeSection = null;

    public function mount(string $slug): void
    {
        $this->document = \App\Domains\Documentation\Models\Document::where('slug', $slug)
            ->where('status', 'published')
            ->with('author')
            ->firstOrFail();

        $this->document->increment('views_count');
    }

    public function setActiveSection(string $section): void
    {
        $this->activeSection = $section;
    }

    public function render()
    {
        $sidebarDocs = \App\Domains\Documentation\Models\Document::where('status', 'published')
            ->where('category', $this->document->category)
            ->orderBy('sort_order')
            ->get();

        return view('livewire.documentation.show', [
            'sidebarDocs' => $sidebarDocs,
        ])->layout('components.layouts.app');
    }
}
