<?php

declare(strict_types=1);

namespace App\Domains\Repositories;

use App\Domains\Components\Contracts\ComponentRepositoryInterface;
use App\Domains\Components\Models\Component;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ComponentRepository implements ComponentRepositoryInterface
{
    public function __construct(
        protected Component $model
    ) {
        $this->model = new Component();
    }

    public function findById(int $id): ?Component
    {
        return $this->model->find($id);
    }

    public function findBySlug(string $slug): ?Component
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function create(array $data): Component
    {
        return $this->model->create($data);
    }

    public function update(Component $component, array $data): Component
    {
        $component->update($data);
        return $component->fresh();
    }

    public function delete(Component $component): bool
    {
        return $component->delete();
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
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('description', 'like', "%{$filters['search']}%")
                  ->orWhere('tags', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getFree(): LengthAwarePaginator
    {
        return $this->model->free()->paginate(15);
    }

    public function getPremium(): LengthAwarePaginator
    {
        return $this->model->premium()->paginate(15);
    }

    public function getFeatured(): LengthAwarePaginator
    {
        return $this->model->featured()->paginate(15);
    }

    public function getByCategory(string $category): LengthAwarePaginator
    {
        return $this->model->where('category', $category)->paginate(15);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->model->where(function (Builder $q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%")
              ->orWhere('tags', 'like', "%{$query}%");
        })->paginate(15);
    }

    public function incrementDownloads(Component $component): void
    {
        $component->increment('downloads_count');
    }

    public function updateRating(Component $component, float $rating): void
    {
        $currentAvg = $component->rating;
        $currentCount = $component->rating_count;
        $newCount = $currentCount + 1;
        $newAvg = (($currentAvg * $currentCount) + $rating) / $newCount;

        $component->update([
            'rating' => round($newAvg, 2),
            'rating_count' => $newCount,
        ]);
    }
}
