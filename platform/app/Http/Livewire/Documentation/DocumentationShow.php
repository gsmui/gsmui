<?php

declare(strict_types=1);

namespace App\Http\Livewire\Documentation;

use Livewire\Component;

class DocumentationShow extends Component
{
    public ?\App\Domains\Documentation\Models\Document $document = null;

    public function mount(string $slug): void
    {
        $this->document = \App\Domains\Documentation\Models\Document::where('slug', $slug)
            ->where('status', 'published')
            ->with('author')
            ->firstOrFail();

        $this->document->increment('views_count');
    }

    public function render()
    {
        return view('livewire.documentation.show')->layout('layouts.app');
    }
}
