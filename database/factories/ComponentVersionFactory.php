<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Components\Models\Component;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComponentVersionFactory extends Factory
{
    protected $model = \App\Domains\Components\Models\Component::class;

    public function definition(): array
    {
        return [
            'version' => fake()->semver(),
            'changelog' => [
                'features' => [fake()->sentence()],
                'fixes' => [fake()->sentence()],
            ],
        ];
    }
}
