<?php

declare(strict_types=1);

namespace App\Infrastructure\Search;

use App\Shared\Contracts\SearchableInterface;
use Illuminate\Support\Facades\DB;

class SearchService
{
    /**
     * Index a model for search.
     */
    public function index(SearchableInterface $model): void
    {
        $data = $model->searchableData();

        DB::table('search_index')->updateOrInsert(
            [
                'searchable_type' => get_class($model),
                'searchable_id' => $model->getKey(),
            ],
            [
                'title' => $data['title'] ?? '',
                'body' => $data['body'] ?? '',
                'keywords' => json_encode($data['keywords'] ?? []),
                'rank' => $data['rank'] ?? 1.0,
                'is_active' => true,
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Remove a model from search index.
     */
    public function remove(SearchableInterface $model): void
    {
        DB::table('search_index')
            ->where('searchable_type', get_class($model))
            ->where('searchable_id', $model->getKey())
            ->delete();
    }

    /**
     * Search across all indexed content.
     */
    public function search(string $query, int $limit = 20): array
    {
        return DB::table('search_index')
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('body', 'LIKE', "%{$query}%")
                  ->orWhere('keywords', 'LIKE', "%{$query}%");
            })
            ->orderBy('rank', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Clear the search index.
     */
    public function clear(): void
    {
        DB::table('search_index')->truncate();
    }

    /**
     * Reindex all searchable models.
     */
    public function reindexAll(): void
    {
        $searchables = [
            \App\Domains\Components\Models\Component::class,
            \App\Domains\Themes\Models\Theme::class,
            \App\Domains\Templates\Models\Template::class,
            \App\Domains\Blog\Models\Post::class,
            \App\Domains\Documentation\Models\Document::class,
        ];

        foreach ($searchables as $modelClass) {
            $modelClass::query()->each(function ($model) {
                $this->index($model);
            });
        }
    }
}
