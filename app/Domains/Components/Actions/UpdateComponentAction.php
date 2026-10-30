<?php

declare(strict_types=1);

namespace App\Domains\Components\Actions;

use App\Domains\Components\DTOs\UpdateComponentData;
use App\Domains\Services\ComponentService;
use App\Domains\Components\Models\Component;
use App\Infrastructure\Cache\CacheService;

class UpdateComponentAction
{
    public function __construct(
        protected ComponentService $componentService,
        protected CacheService $cache
    ) {}

    public function execute(Component $component, UpdateComponentData $data): Component
    {
        $updated = $this->componentService->update($component, $data);

        $this->cache->invalidate('components');
        $this->cache->forget("component_{$component->slug}");

        return $updated;
    }
}
