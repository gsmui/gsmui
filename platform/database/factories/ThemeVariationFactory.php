<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeVariationFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'tokens' => [
                'color-primary' => fake()->hexColor(),
                'color-secondary' => fake()->hexColor(),
            ],
            'downloads_count' => fake()->numberBetween(0, 2000),
            'rating' => fake()->randomFloat(1, 1, 5),
            'rating_count' => fake()->numberBetween(0, 30),
            'is_featured' => fake()->boolean(15),
            'version' => fake()->semver(),
            'tags' => fake()->words(3),
        ];
    }
}
