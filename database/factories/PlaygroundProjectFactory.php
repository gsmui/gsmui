<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Playground\Models\Project;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaygroundProjectFactory extends Factory
{
    protected $model = PlaygroundProject::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => fake()->optional()->paragraph(),
            'files' => [
                'index.blade.php' => '<div>Hello World</div>',
                'style.css' => 'body { margin: 0; }',
            ],
            'visibility' => fake()->randomElement(['private', 'public']),
            'forked_from_id' => null,
            'forks_count' => fake()->numberBetween(0, 50),
            'views_count' => fake()->numberBetween(0, 1000),
        ];
    }

    public function public(): static
    {
        return $this->state(fn () => ['visibility' => 'public']);
    }
}
