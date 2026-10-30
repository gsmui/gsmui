<?php

declare(strict_types=1);

namespace App\Domains\Analytics\Actions;

use App\Domains\Services\AnalyticsService;
use App\Domains\Users\Models\User;

class TrackPageViewAction
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {}

    public function execute(string $page, ?User $user = null): void
    {
        $this->analyticsService->recordPageView($page, $user?->id);
    }
}
