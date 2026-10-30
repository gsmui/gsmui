<?php

declare(strict_types=1);

namespace App\Domains\Components\Contracts;

use App\Domains\Components\Models\Component;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ComponentRepositoryInterface
{
    public function findById(int $id): ?Component;
    public function findBySlug(string $slug): ?Component;
    public function create(array $data): Component;
    public function update(Component $component, array $data): Component;
    public function delete(Component $component): bool;
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function getFree(): LengthAwarePaginator;
    public function getPremium(): LengthAwarePaginator;
    public function getFeatured(): LengthAwarePaginator;
    public function getByCategory(string $category): LengthAwarePaginator;
    public function search(string $query): LengthAwarePaginator;
    public function incrementDownloads(Component $component): void;
    public function updateRating(Component $component, float $rating): void;
}
