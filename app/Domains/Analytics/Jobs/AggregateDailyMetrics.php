<?php

declare(strict_types=1);

namespace App\Domains\Analytics\Jobs;

use App\Domains\Analytics\Models\Metric;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AggregateDailyMetrics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        $yesterday = now()->subDay()->toDateString();

        $aggregatedMetrics = Metric::whereDate('recorded_at', $yesterday)
            ->select(
                'name',
                'type',
                DB::raw('SUM(value) as total_value'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('name', 'type')
            ->get();

        foreach ($aggregatedMetrics as $metric) {
            // Store aggregated metrics for reporting
        }
    }
}
