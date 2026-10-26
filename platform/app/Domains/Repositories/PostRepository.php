<?php

declare(strict_types=1);

namespace App\Domains\Repositories;

use App\Domains\Blog\Contracts\PostRepositoryInterface;
use App\Domains\Blog\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(
        protected Post $model
    ) {
        $this->model = new Post();
    }

    public function findById(int $id): ?Post
    {
        return $this->model->find($id);
    }

    public function findBySlug(string $slug): ?Post
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function create(array $data): Post
    {
        return $this->model->create($data);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post->fresh();
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['search'])) {
            $query->where(function (Builder $q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                  ->orWhere('body', 'like', "%{$filters['search']}%")
                  ->orWhere('tags', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->model->where(function (Builder $q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('body', 'like', "%{$query}%")
              ->orWhere('tags', 'like', "%{$query}%");
        })->paginate(15);
    }

    public function incrementViews(Post $post): void
    {
        $post->increment('views_count');
    }
}
