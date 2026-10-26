<?php

declare(strict_types=1);

namespace App\Domains\Components\Contracts;

use App\Domains\Components\DTOs\CreateComponentData;
use App\Domains\Components\DTOs\UpdateComponentData;
use App\Domains\Components\Models\Component;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ComponentServiceInterface
{
    public function create(CreateComponentData $data): Component;
    public function update(Component $component, UpdateComponentData $data): Component;
    public function delete(Component $component): bool;
    public function publish(Component $component): Component;
    public function deprecate(Component $component): Component;
    public function getById(int $id): ?Component;
    public function getBySlug(string $slug): ?Component;
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function getFree(): LengthAwarePaginator;
    public function getPremium(): LengthAwarePaginator;
    public function getFeatured(): LengthAwarePaginator;
    public function getByCategory(string $category): LengthAwarePaginator;
    public function search(string $query): LengthAwarePaginator;
    public function recordDownload(Component $component): void;
}
