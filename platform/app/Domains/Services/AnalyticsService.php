<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Analytics\Models\Metric;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function record(string $name, float $value, string $type = 'counter', array $dimensions = []): Metric
    {
        return Metric::create([
            'name' => $name,
            'value' => $value,
            'type' => $type,
            'dimensions' => $dimensions,
            'recorded_at' => now(),
        ]);
    }

    public function getMetrics(string $name, string $period = 'day', int $days = 30): array
    {
        return Metric::where('name', $name)
            ->where('recorded_at', '>=', now()->subDays($days))
            ->select(
                DB::raw('DATE(recorded_at) as date'),
                DB::raw('SUM(value) as total'),
                DB::raw('AVG(value) as average'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    public function getDashboardStats(): array
    {
        return [
            'total_users' => \App\Domains\Users\Models\User::count(),
            'active_users' => \App\Domains\Users\Models\User::where('last_active_at', '>=', now()->subDays(30))->count(),
            'total_components' => \App\Domains\Components\Models\Component::count(),
            'total_themes' => \App\Domains\Themes\Models\Theme::count(),
            'total_templates' => \App\Domains\Templates\Models\Template::count(),
            'total_downloads' => \App\Domains\Components\Models\Component::sum('downloads_count'),
            'revenue_this_month' => \App\Domains\Billing\Models\Invoice::where('status', 'paid')
                ->where('created_at', '>=', now()->startOfMonth())
                ->sum('amount'),
            'new_users_this_month' => \App\Domains\Users\Models\User::where('created_at', '>=', now()->startOfMonth())->count(),
        ];
    }

    public function recordPageView(string $page, ?int $userId = null): void
    {
        $this->record('page_view', 1, 'counter', [
            'page' => $page,
            'user_id' => $userId,
        ]);
    }

    public function recordDownload(string $type, int $id): void
    {
        $this->record('download', 1, 'counter', [
            'type' => $type,
            'id' => $id,
        ]);
    }
}
