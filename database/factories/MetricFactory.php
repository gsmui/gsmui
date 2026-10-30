<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Analytics\Models\Metric;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetricFactory extends Factory
{
    protected $model = Metric::class;

    public function definition(): array
    {
        $name = fake()->randomElement([
            'page_views', 'unique_visitors', 'signups', 'downloads',
            'revenue', 'component_usage', 'api_requests', 'active_users',
        ]);

        return [
            'name' => $name,
            'type' => fake()->randomElement(['counter', 'gauge', 'histogram']),
            'value' => fake()->randomFloat(2, 0, 10000),
            'dimensions' => fake()->optional(50)->words(3),
            'recorded_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    public function forPageViews(): static
    {
        return $this->state(fn () => [
            'name' => 'page_views',
            'type' => 'counter',
            'value' => fake()->numberBetween(100, 50000),
        ]);
    }

    public function forRevenue(): static
    {
        return $this->state(fn () => [
            'name' => 'revenue',
            'type' => 'gauge',
            'value' => fake()->randomFloat(2, 100, 50000),
        ]);
    }
}
