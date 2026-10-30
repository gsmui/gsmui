<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProductEdit extends Component
{
    use WithFileUploads;

    public ?\App\Domains\Marketplace\Models\Product $product = null;
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
    public string $status = 'draft';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'description' => 'required|string|max:10000',
        'type' => 'required|string|in:component,template,tool,service',
        'price' => 'required|numeric|min:0',
        'salePrice' => 'nullable|numeric|min:0|lt:price',
        'previewImage' => 'nullable|string|max:500',
        'demoUrl' => 'nullable|url|max:500',
        'version' => 'required|string|max:50',
        'changelog' => 'nullable|string|max:5000',
        'tags' => 'nullable|array',
        'status' => 'in:draft,published,archived',
    ];

    public function mount(string $slug): void
    {
        $this->product = \App\Domains\Marketplace\Models\Product::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $this->product->author_id) {
            abort(403);
        }

        $this->name = $this->product->name;
        $this->slug = $this->product->slug;
        $this->description = $this->product->description;
        $this->type = $this->product->type;
        $this->price = (float) $this->product->price;
        $this->salePrice = $this->product->sale_price ? (float) $this->product->sale_price : null;
        $this->previewImage = $this->product->preview_image;
        $this->demoUrl = $this->product->demo_url;
        $this->version = $this->product->version;
        $this->changelog = is_array($this->product->changelog) ? implode("\n", $this->product->changelog) : $this->product->changelog;
        $this->tags = $this->product->tags;
        $this->status = $this->product->status;
    }

    public function save() 
    {
        $this->validate();

        $this->product->update([
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
            'status' => $this->status,
        ]);

        return redirect()->route('marketplace.show', $this->product->slug)
            ->with('success', 'Product updated successfully!');
    }

    public function delete() 
    {
        if (auth()->id() !== $this->product->author_id) {
            abort(403);
        }

        $this->product->delete();

        return redirect()->route('marketplace.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function render()
    {
        return view('livewire.marketplace.edit')->layout('components.layouts.app');
    }
}
