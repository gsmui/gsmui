<?php

declare(strict_types=1);

namespace App\Domains\Analytics\Actions;

use App\Domains\Services\AnalyticsService;

class GenerateReportAction
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {}

    public function execute(string $period = 'day', int $days = 30): array
    {
        $dashboardStats = $this->analyticsService->getDashboardStats();

        $userMetrics = $this->analyticsService->getMetrics('page_view', $period, $days);

        $downloadMetrics = $this->analyticsService->getMetrics('download', $period, $days);

        return [
            'dashboard' => $dashboardStats,
            'page_views' => $userMetrics,
            'downloads' => $downloadMetrics,
            'generated_at' => now()->toIso8601String(),
        ];
    }
}
