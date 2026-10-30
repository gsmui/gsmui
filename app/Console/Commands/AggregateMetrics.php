<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domains\Analytics\Models\Metric;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AggregateMetrics extends Command
{
    protected $signature = 'metrics:aggregate {days=30}';
    protected $description = 'Aggregate daily metrics for reporting';

    public function handle(): int
    {
        $days = (int) $this->argument('days');
        $yesterday = now()->subDay()->toDateString();

        $this->info("Aggregating metrics for {$yesterday}...");

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
            $this->info("  - {$metric->name} ({$metric->type}): {$metric->total_value}");
        }

        $this->info('Metrics aggregation complete!');

        return Command::SUCCESS;
    }
}
