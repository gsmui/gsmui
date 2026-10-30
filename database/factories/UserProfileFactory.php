<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domains\Users\Models\User;
use App\Domains\Users\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    protected $model = UserProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company' => fake()->optional()->company(),
            'location' => fake()->optional()->city() . ', ' . fake()->country(),
            'timezone' => fake()->randomElement(['UTC', 'America/New_York', 'Europe/London', 'Asia/Tokyo', 'Asia/Dubai']),
            'language' => fake()->randomElement(['en', 'es', 'fr', 'de', 'ar', 'ja']),
            'theme_preference' => fake()->randomElement(['light', 'dark', 'system']),
            'notification_preferences' => [
                'email' => fake()->boolean(80),
                'browser' => fake()->boolean(60),
                'marketing' => fake()->boolean(30),
            ],
            'social_links' => [
                'github' => fake()->optional()->url(),
                'twitter' => fake()->optional()->url(),
                'linkedin' => fake()->optional()->url(),
            ],
        ];
    }
}
