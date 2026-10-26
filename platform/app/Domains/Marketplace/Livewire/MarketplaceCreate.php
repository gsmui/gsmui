<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class MarketplaceCreate extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public string $type = 'component';
    public float $price = 0;
    public ?float $salePrice = null;
    public ?string $previewImage = null;
    public ?string $demoUrl = null;
    public string $version = '1.0.0';
    public ?string $changelog = null;
    public ?array $tags = null;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:products,slug',
        'description' => 'required|string|max:10000',
        'type' => 'required|string|in:component,template,tool,service',
        'price' => 'required|numeric|min:0',
        'salePrice' => 'nullable|numeric|min:0|lt:price',
        'previewImage' => 'nullable|string|max:500',
        'demoUrl' => 'nullable|url|max:500',
        'version' => 'required|string|max:50',
        'changelog' => 'nullable|string|max:5000',
        'tags' => 'nullable|array',
    ];

    public function updatedName(): void
    {
        if (empty($this->slug)) {
            $this->slug = \Illuminate\Support\Str::slug($this->name);
        }
    }

    public function save(): void
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        $product = \App\Domains\Marketplace\Models\Product::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => $this->type,
            'price' => $this->price,
            'sale_price' => $this->salePrice,
            'preview_image' => $this->previewImage,
            'demo_url' => $this->demoUrl,
            'version' => $this->version,
            'changelog' => $this->changelog ? [$this->changelog] : null,
            'tags' => $this->tags,
            'author_id' => auth()->id(),
            'status' => 'draft',
        ]);

        return redirect()->route('marketplace.show', $product->slug)
            ->with('success', 'Product submitted successfully!');
    }

    public function render()
    {
        return view('livewire.marketplace.create')->layout('layouts.app');
    }
}
