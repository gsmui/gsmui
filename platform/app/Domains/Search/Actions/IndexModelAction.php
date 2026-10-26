<?php

declare(strict_types=1);

namespace App\Domains\Search\Actions;

use App\Domains\Search\Models\SearchIndex;
use App\Infrastructure\Search\SearchService;

class IndexModelAction
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    public function execute(object $model): void
    {
        $this->searchService->index($model);
    }

    public function remove(object $model): void
    {
        $this->searchService->remove($model);
    }

    public function rebuildIndex(): void
    {
        $models = [
            \App\Domains\Components\Models\Component::class,
            \App\Domains\Themes\Models\Theme::class,
            \App\Domains\Blog\Models\Post::class,
            \App\Domains\Documentation\Models\Document::class,
            \App\Domains\Marketplace\Models\Product::class,
        ];

        foreach ($models as $modelClass) {
            $modelClass::query()->chunk(100, function ($models) {
                foreach ($models as $model) {
                    $this->searchService->index($model);
                }
            });
        }
    }
}
