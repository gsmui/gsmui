<?php

declare(strict_types=1);

namespace App\Domains\Components\Actions;

use App\Domains\Services\ComponentService;
use App\Domains\Components\Models\Component;
use App\Infrastructure\Cache\CacheService;
use App\Infrastructure\Search\SearchService;

class PublishComponentAction
{
    public function __construct(
        protected ComponentService $componentService,
        protected CacheService $cache,
        protected SearchService $searchService
    ) {}

    public function execute(Component $component): Component
    {
        $published = $this->componentService->publish($component);

        $this->cache->invalidate('components');
        $this->searchService->index($published);

        return $published;
    }
}
