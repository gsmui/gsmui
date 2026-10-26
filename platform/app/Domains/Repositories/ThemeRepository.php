<?php

declare(strict_types=1);

namespace App\Domains\Repositories;

use App\Domains\Themes\Contracts\ThemeRepositoryInterface;
use App\Domains\Themes\Models\Theme;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ThemeRepository implements ThemeRepositoryInterface
{
    public function __construct(
        protected Theme $model
    ) {
        $this->model = new Theme();
    }

    public function findById(int $id): ?Theme
    {
        return $this->model->find($id);
    }

    public function findBySlug(string $slug): ?Theme
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function create(array $data): Theme
    {
        return $this->model->create($data);
    }

    public function update(Theme $theme, array $data): Theme
    {
        $theme->update($data);
        return $theme->fresh();
    }

    public function delete(Theme $theme): bool
    {
        return $theme->delete();
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
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

    public function search(string $query): LengthAwarePaginator
    {
        return $this->model->where(function (Builder $q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%")
              ->orWhere('tags', 'like', "%{$query}%");
        })->paginate(15);
    }

    public function incrementDownloads(Theme $theme): void
    {
        $theme->increment('downloads_count');
    }
}
