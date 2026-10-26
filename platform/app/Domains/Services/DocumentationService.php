<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Documentation\Models\Document;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DocumentationService
{
    public function __construct(
        protected \App\Domains\Documentation\Contracts\DocumentRepositoryInterface $repository
    ) {}

    public function create(array $data): Document
    {
        return $this->repository->create($data);
    }

    public function update(Document $document, array $data): Document
    {
        return $this->repository->update($document, $data);
    }

    public function delete(Document $document): bool
    {
        return $this->repository->delete($document);
    }

    public function publish(Document $document): Document
    {
        return $this->repository->update($document, ['status' => 'published']);
    }

    public function getBySlug(string $slug): ?Document
    {
        return $this->repository->findBySlug($slug);
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->list($filters, $perPage);
    }

    public function getByCategory(string $category): LengthAwarePaginator
    {
        return $this->repository->getByCategory($category);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->repository->search($query);
    }

    public function incrementViews(Document $document): void
    {
        $this->repository->incrementViews($document);
    }
}
