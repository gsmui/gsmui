<?php

declare(strict_types=1);

namespace App\Domains\Components\Actions;

use App\Domains\Services\ComponentService;
use App\Domains\Services\AnalyticsService;
use App\Domains\Components\Models\Component;
use App\Domains\Users\Models\User;

class DownloadComponentAction
{
    public function __construct(
        protected ComponentService $componentService,
        protected AnalyticsService $analyticsService
    ) {}

    public function execute(Component $component, User $user): void
    {
        $this->componentService->recordDownload($component);

        $this->analyticsService->recordDownload('component', $component->id);
    }
}
