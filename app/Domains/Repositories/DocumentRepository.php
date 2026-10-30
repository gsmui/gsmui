<?php

declare(strict_types=1);

namespace App\Domains\Repositories;

use App\Domains\Documentation\Contracts\DocumentRepositoryInterface;
use App\Domains\Documentation\Models\Document;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class DocumentRepository implements DocumentRepositoryInterface
{
    public function __construct(
        protected Document $model
    ) {
        $this->model = new Document();
    }

    public function findById(int $id): ?Document
    {
        return $this->model->find($id);
    }

    public function findBySlug(string $slug): ?Document
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function create(array $data): Document
    {
        return $this->model->create($data);
    }

    public function update(Document $document, array $data): Document
    {
        $document->update($data);
        return $document->fresh();
    }

    public function delete(Document $document): bool
    {
        return $document->delete();
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['search'])) {
            $query->where(function (Builder $q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                  ->orWhere('body', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('sort_order')->paginate($perPage);
    }

    public function getByCategory(string $category): LengthAwarePaginator
    {
        return $this->model->where('category', $category)->orderBy('sort_order')->paginate(15);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->model->where(function (Builder $q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('body', 'like', "%{$query}%");
        })->paginate(15);
    }

    public function incrementViews(Document $document): void
    {
        $document->increment('views_count');
    }
}
