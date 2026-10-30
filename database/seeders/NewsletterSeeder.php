<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    public function run(): void
    {
        $subscribers = [
            ['email' => 'sarah@example.com', 'name' => 'Sarah Chen'],
            ['email' => 'marcus@example.com', 'name' => 'Marcus Rivera'],
            ['email' => 'elena@example.com', 'name' => 'Elena Popov'],
            ['email' => 'james@example.com', 'name' => 'James Mitchell'],
            ['email' => 'aisha@example.com', 'name' => 'Aisha Patel'],
            ['email' => 'thomas@example.com', 'name' => 'Thomas Berg'],
            ['email' => 'yuki@example.com', 'name' => 'Yuki Tanaka'],
            ['email' => 'david@example.com', 'name' => 'David Okonkwo'],
            ['email' => 'lisa@example.com', 'name' => 'Lisa Johansson'],
            ['email' => 'ahmed@example.com', 'name' => 'Ahmed Hassan'],
            ['email' => 'maria@example.com', 'name' => 'Maria Garcia'],
            ['email' => 'kevin@example.com', 'name' => 'Kevin O\'Brien'],
        ];

        foreach ($subscribers as $subscriber) {
            NewsletterSubscriber::create([
                ...$subscriber,
                'token' => \Illuminate\Support\Str::random(60),
                'subscribed_at' => fake()->dateTimeBetween('-6 months', 'now'),
                'active' => true,
            ]);
        }

        $fakerSubscribers = collect(range(1, 48))->map(function () {
            return [
                'email' => fake()->unique()->safeEmail(),
                'name' => fake()->optional(80)->name(),
                'token' => \Illuminate\Support\Str::random(60),
                'subscribed_at' => fake()->dateTimeBetween('-1 year', 'now'),
                'active' => fake()->boolean(85),
            ];
        });

        foreach ($fakerSubscribers as $subscriber) {
            NewsletterSubscriber::create($subscriber);
        }
    }
}
