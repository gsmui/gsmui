<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Users\Models\ApiKey;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApiKeyFactory extends Factory
{
    protected $model = ApiKey::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement(['Production', 'Staging', 'Development', 'CI/CD', 'Local']),
            'abilities' => fake()->randomElements(['read', 'write', 'delete', 'admin'], fake()->numberBetween(1, 4)),
            'last_used_at' => fake()->optional(80)->dateTimeBetween('-30 days', 'now'),
            'expires_at' => fake()->optional(60)->dateTimeBetween('+1 month', '+1 year'),
        ];
    }
}
