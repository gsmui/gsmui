<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Component;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComponentFactory extends Factory
{
    protected $model = Component::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement(['form', 'data-display', 'navigation', 'feedback', 'layout', 'typography', 'media', 'charts', 'tables', 'overlays']),
            'subcategory' => fake()->optional()->word(),
            'version' => fake()->semver(),
            'status' => fake()->randomElement(['draft', 'published', 'deprecated']),
            'is_free' => fake()->boolean(70),
            'is_premium' => fake()->boolean(30),
            'price' => fake()->optional()->randomFloat(2, 9, 99),
            'code_example' => '<x-gsmui-' . \Illuminate\Support\Str::slug($name) . ' />',
            'installation_guide' => fake()->paragraph(),
            'props_documentation' => fake()->paragraph(),
            'events_documentation' => fake()->optional()->paragraph(),
            'slots_documentation' => fake()->optional()->paragraph(),
            'accessibility_notes' => fake()->optional()->paragraph(),
            'dependencies' => fake()->optional()->elements(['tailwindcss', 'alpinejs']),
            'tags' => fake()->words(3),
            'changelog' => ['1.0.0' => 'Initial release'],
            'downloads_count' => fake()->numberBetween(0, 10000),
            'rating' => fake()->randomFloat(1, 1, 5),
            'rating_count' => fake()->numberBetween(0, 100),
            'is_featured' => fake()->boolean(20),
            'is_deprecated' => fake()->boolean(5),
            'author_id' => User::factory(),
        ];
    }
}
