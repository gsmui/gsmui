<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Components\Contracts\ComponentRepositoryInterface;
use App\Domains\Components\Contracts\ComponentServiceInterface;
use App\Domains\Components\DTOs\CreateComponentData;
use App\Domains\Components\DTOs\UpdateComponentData;
use App\Domains\Components\Models\Component;
use App\Domains\Components\Events\ComponentCreated;
use App\Domains\Components\Events\ComponentPublished;
use App\Domains\Components\Events\ComponentDeprecated;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ComponentService implements ComponentServiceInterface
{
    public function __construct(
        protected ComponentRepositoryInterface $repository
    ) {}

    public function create(CreateComponentData $data): Component
    {
        $component = $this->repository->create($data->toArray());

        event(new ComponentCreated($component));

        return $component;
    }

    public function update(Component $component, UpdateComponentData $data): Component
    {
        return $this->repository->update($component, $data->toArray());
    }

    public function delete(Component $component): bool
    {
        return $this->repository->delete($component);
    }

    public function publish(Component $component): Component
    {
        $component = $this->repository->update($component, ['status' => 'published']);

        event(new ComponentPublished($component));

        return $component;
    }

    public function deprecate(Component $component): Component
    {
        $component = $this->repository->update($component, [
            'status' => 'deprecated',
            'is_deprecated' => true,
        ]);

        event(new ComponentDeprecated($component));

        return $component;
    }

    public function getById(int $id): ?Component
    {
        return $this->repository->findById($id);
    }

    public function getBySlug(string $slug): ?Component
    {
        return $this->repository->findBySlug($slug);
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->list($filters, $perPage);
    }

    public function getFree(): LengthAwarePaginator
    {
        return $this->repository->getFree();
    }

    public function getPremium(): LengthAwarePaginator
    {
        return $this->repository->getPremium();
    }

    public function getFeatured(): LengthAwarePaginator
    {
        return $this->repository->getFeatured();
    }

    public function getByCategory(string $category): LengthAwarePaginator
    {
        return $this->repository->getByCategory($category);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->repository->search($query);
    }

    public function recordDownload(Component $component): void
    {
        $this->repository->incrementDownloads($component);
    }
}
