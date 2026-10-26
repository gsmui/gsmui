<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Blog\Models\Post;
use App\Domains\Blog\Models\PostCategory;
use App\Domains\Blog\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogService
{
    public function __construct(
        protected \App\Domains\Blog\Contracts\PostRepositoryInterface $repository
    ) {}

    public function createPost(array $data): Post
    {
        return $this->repository->create($data);
    }

    public function updatePost(Post $post, array $data): Post
    {
        return $this->repository->update($post, $data);
    }

    public function deletePost(Post $post): bool
    {
        return $this->repository->delete($post);
    }

    public function publishPost(Post $post): Post
    {
        return $this->repository->update($post, [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function getPost(string $slug): ?Post
    {
        return $this->repository->findBySlug($slug);
    }

    public function listPosts(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->list($filters, $perPage);
    }

    public function addComment(Post $post, array $data): Comment
    {
        return $post->comments()->create($data);
    }

    public function getCategories()
    {
        return PostCategory::orderBy('sort_order')->get();
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->repository->search($query);
    }
}
