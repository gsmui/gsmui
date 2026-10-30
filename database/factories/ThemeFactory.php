<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Themes\Models\Theme;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['draft', 'published']),
            'is_free' => fake()->boolean(70),
            'is_premium' => fake()->boolean(30),
            'price' => fake()->optional()->randomFloat(2, 9, 49),
            'tokens' => [
                'color-primary' => fake()->hexColor(),
                'color-secondary' => fake()->hexColor(),
                'color-accent' => fake()->hexColor(),
                'font-sans' => 'Inter, system-ui, sans-serif',
                'radius' => '0.5rem',
            ],
            'downloads_count' => fake()->numberBetween(0, 5000),
            'rating' => fake()->randomFloat(1, 1, 5),
            'rating_count' => fake()->numberBetween(0, 50),
            'is_featured' => fake()->boolean(20),
            'version' => fake()->semver(),
            'changelog' => ['1.0.0' => 'Initial release'],
            'tags' => fake()->words(3),
            'author_id' => User::factory(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['status' => 'published']);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => 'draft']);
    }
}
