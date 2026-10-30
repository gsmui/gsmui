<?php

declare(strict_types=1);

namespace App\Domains\Components\Actions;

use App\Domains\Components\DTOs\CreateComponentData;
use App\Domains\Services\ComponentService;
use App\Domains\Components\Models\Component;
use App\Infrastructure\Cache\CacheService;

class CreateComponentAction
{
    public function __construct(
        protected ComponentService $componentService,
        protected CacheService $cache
    ) {}

    public function execute(CreateComponentData $data): Component
    {
        $component = $this->componentService->create($data);

        $this->cache->invalidate('components');

        return $component;
    }
}
