<?php

declare(strict_types=1);

namespace App\Domains\Components\Actions;

use App\Domains\Services\ComponentService;
use App\Domains\Components\Models\Component;
use App\Infrastructure\Cache\CacheService;
use App\Infrastructure\Search\SearchService;

class DeleteComponentAction
{
    public function __construct(
        protected ComponentService $componentService,
        protected CacheService $cache,
        protected SearchService $searchService
    ) {}

    public function execute(Component $component): bool
    {
        $this->searchService->remove($component);

        $deleted = $this->componentService->delete($component);

        $this->cache->invalidate('components');
        $this->cache->forget("component_{$component->slug}");

        return $deleted;
    }
}
