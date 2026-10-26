<?php

declare(strict_types=1);

namespace App\Domains\Blog\Livewire;

use Livewire\Component;

class BlogCreate extends Component
{
    public string $title = '';
    public string $slug = '';
    public string $body = '';
    public ?string $excerpt = null;
    public ?int $categoryId = null;
    public ?string $featuredImage = null;
    public ?string $metaTitle = null;
    public ?string $metaDescription = null;
    public ?array $tags = null;
    public bool $publishNow = false;

    protected array $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug',
        'body' => 'required|string|max:50000',
        'excerpt' => 'nullable|string|max:500',
        'categoryId' => 'nullable|integer|exists:post_categories,id',
        'featuredImage' => 'nullable|string|max:500',
        'metaTitle' => 'nullable|string|max:255',
        'metaDescription' => 'nullable|string|max:500',
        'tags' => 'nullable|array',
        'publishNow' => 'boolean',
    ];

    protected array $validationAttributes = [
        'title' => 'title',
        'slug' => 'slug',
        'body' => 'body',
        'excerpt' => 'excerpt',
        'categoryId' => 'category',
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

        $post = \App\Domains\Blog\Models\Post::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'excerpt' => $this->excerpt,
            'category_id' => $this->categoryId,
            'featured_image' => $this->featuredImage,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'tags' => $this->tags,
            'author_id' => auth()->id(),
            'status' => $this->publishNow ? 'published' : 'draft',
            'published_at' => $this->publishNow ? now() : null,
        ]);

        return redirect()->route('blog.show', $post->slug)
            ->with('success', 'Post created successfully!');
    }

    public function render()
    {
        return view('livewire.blog.create', [
            'categories' => \App\Domains\Blog\Models\PostCategory::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
