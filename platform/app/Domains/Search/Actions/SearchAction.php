<?php

declare(strict_types=1);

namespace App\Domains\Search\Actions;

use App\Infrastructure\Search\SearchService;

class SearchAction
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    public function execute(string $query, array $filters = [], int $perPage = 15): array
    {
        $results = $this->searchService->search($query, $filters, $perPage);

        $grouped = collect($results['data'] ?? [])
            ->groupBy(fn($item) => class_basename(get_class($item)))
            ->map(fn($items) => $items->toArray())
            ->toArray();

        return [
            'query' => $query,
            'results' => $grouped,
            'total' => $results['total'] ?? 0,
            'page' => $results['page'] ?? 1,
            'per_page' => $perPage,
        ];
    }

    public function suggest(string $query, int $limit = 5): array
    {
        return $this->searchService->suggest($query, $limit);
    }
}
