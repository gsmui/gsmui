<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Metric;
use Illuminate\Database\Seeder;

class MetricSeeder extends Seeder
{
    public function run(): void
    {
        $metrics = [
            ['name' => 'page_views', 'type' => 'counter'],
            ['name' => 'unique_visitors', 'type' => 'counter'],
            ['name' => 'signups', 'type' => 'counter'],
            ['name' => 'downloads', 'type' => 'counter'],
            ['name' => 'revenue', 'type' => 'gauge'],
            ['name' => 'component_usage', 'type' => 'counter'],
            ['name' => 'api_requests', 'type' => 'counter'],
            ['name' => 'active_users', 'type' => 'gauge'],
        ];

        foreach ($metrics as $metricDef) {
            for ($day = 30; $day >= 0; $day--) {
                $baseValue = match ($metricDef['name']) {
                    'page_views' => 5000,
                    'unique_visitors' => 2000,
                    'signups' => 50,
                    'downloads' => 200,
                    'revenue' => 1500,
                    'component_usage' => 3000,
                    'api_requests' => 10000,
                    'active_users' => 800,
                    default => 100,
                };

                $variation = $baseValue * 0.3;
                $value = $baseValue + fake()->randomFloat(2, -$variation, $variation);

                Metric::create([
                    'name' => $metricDef['name'],
                    'type' => $metricDef['type'],
                    'value' => max(0, $value),
                    'dimensions' => fake()->optional(40)->words(2),
                    'recorded_at' => now()->subDays($day)->startOfDay(),
                ]);
            }
        }
    }
}
