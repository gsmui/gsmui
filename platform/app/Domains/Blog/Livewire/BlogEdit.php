<?php

declare(strict_types=1);

namespace App\Domains\Blog\Livewire;

use Livewire\Component;

class BlogEdit extends Component
{
    public ?\App\Domains\Blog\Models\Post $post = null;
    public string $title = '';
    public string $slug = '';
    public string $body = '';
    public ?string $excerpt = null;
    public ?int $categoryId = null;
    public ?string $featuredImage = null;
    public ?string $metaTitle = null;
    public ?string $metaDescription = null;
    public ?array $tags = null;
    public string $status = 'draft';

    protected array $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'body' => 'required|string|max:50000',
        'excerpt' => 'nullable|string|max:500',
        'categoryId' => 'nullable|integer|exists:post_categories,id',
        'featuredImage' => 'nullable|string|max:500',
        'metaTitle' => 'nullable|string|max:255',
        'metaDescription' => 'nullable|string|max:500',
        'tags' => 'nullable|array',
        'status' => 'in:draft,published,archived',
    ];

    public function mount(string $slug): void
    {
        $this->post = \App\Domains\Blog\Models\Post::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $this->post->author_id) {
            abort(403);
        }

        $this->title = $this->post->title;
        $this->slug = $this->post->slug;
        $this->body = $this->post->body;
        $this->excerpt = $this->post->excerpt;
        $this->categoryId = $this->post->category_id;
        $this->featuredImage = $this->post->featured_image;
        $this->metaTitle = $this->post->meta_title;
        $this->metaDescription = $this->post->meta_description;
        $this->tags = $this->post->tags;
        $this->status = $this->post->status;
    }

    public function updatedTitle(): void
    {
        if ($this->post && empty($this->slug)) {
            $this->slug = \Illuminate\Support\Str::slug($this->title);
        }
    }

    public function save(): void
    {
        $this->validate();

        $wasPublished = $this->post->status === 'published';
        $isPublishing = $this->status === 'published' && !$wasPublished;

        $this->post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'excerpt' => $this->excerpt,
            'category_id' => $this->categoryId,
            'featured_image' => $this->featuredImage,
            'meta_title' => $this->metaTitle,
            'meta_description' => $this->metaDescription,
            'tags' => $this->tags,
            'status' => $this->status,
            'published_at' => $isPublishing ? now() : $this->post->published_at,
        ]);

        return redirect()->route('blog.show', $this->post->slug)
            ->with('success', 'Post updated successfully!');
    }

    public function delete(): void
    {
        if (auth()->id() !== $this->post->author_id) {
            abort(403);
        }

        $this->post->delete();

        return redirect()->route('blog.index')
            ->with('success', 'Post deleted successfully!');
    }

    public function render()
    {
        return view('livewire.blog.edit', [
            'categories' => \App\Domains\Blog\Models\PostCategory::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
