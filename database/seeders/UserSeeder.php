<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Sarah Chen', 'username' => 'sarahchen', 'email' => 'sarah@example.com', 'bio' => 'Full-stack developer specializing in Laravel and Livewire. Building beautiful UIs with GsmUi.', 'website' => 'https://sarahchen.dev', 'github_username' => 'sarahchen', 'twitter_username' => 'sarahchen_dev'],
            ['name' => 'Marcus Rivera', 'username' => 'marcusrivera', 'email' => 'marcus@example.com', 'bio' => 'UI/UX designer turned developer. Passionate about accessible web design.', 'website' => 'https://marcusrivera.com', 'github_username' => 'marcusdev'],
            ['name' => 'Elena Popov', 'username' => 'elenapopov', 'email' => 'elena@example.com', 'bio' => 'Frontend engineer at a SaaS startup. Contributing to open source component libraries.', 'twitter_username' => 'elena_codes'],
            ['name' => 'James Mitchell', 'username' => 'jamesmitchell', 'email' => 'james@example.com', 'bio' => 'Freelance developer building admin panels and dashboards for clients worldwide.', 'website' => 'https://jamesmitchell.io', 'github_username' => 'jmitchell'],
            ['name' => 'Aisha Patel', 'username' => 'aishapatel', 'email' => 'aisha@example.com', 'bio' => 'DevOps engineer who loves clean code and elegant interfaces.', 'github_username' => 'aishap', 'twitter_username' => 'aisha_codes'],
            ['name' => 'Thomas Berg', 'username' => 'thomasberg', 'email' => 'thomas@example.com', 'bio' => 'Senior Laravel developer. Building enterprise applications with GsmUi Pro.', 'website' => 'https://thomasberg.dev', 'github_username' => 'tberg'],
            ['name' => 'Yuki Tanaka', 'username' => 'yukitanaka', 'email' => 'yuki@example.com', 'bio' => 'JavaScript and PHP developer. Creating themes and templates for the GsmUi marketplace.', 'twitter_username' => 'yuki_dev'],
            ['name' => 'David Okonkwo', 'username' => 'davidokonkwo', 'email' => 'david@example.com', 'bio' => 'Full-stack developer from Lagos. Building SaaS products with Laravel.', 'github_username' => 'davidok'],
            ['name' => 'Lisa Johansson', 'username' => 'lisajohansson', 'email' => 'lisa@example.com', 'bio' => 'Product designer and developer. Focused on creating delightful user experiences.', 'website' => 'https://lisaj.se'],
            ['name' => 'Ahmed Hassan', 'username' => 'ahmedhassan', 'email' => 'ahmed@example.com', 'bio' => 'Backend developer exploring frontend with Livewire and GsmUi components.', 'github_username' => 'ahmedh'],
            ['name' => 'Maria Garcia', 'username' => 'mariagarcia', 'email' => 'maria@example.com', 'bio' => 'Tech lead at a fintech company. Building secure and scalable web applications.', 'twitter_username' => 'maria_tech'],
            ['name' => 'Kevin O\'Brien', 'username' => 'kevinobrien', 'email' => 'kevin@example.com', 'bio' => 'Indie hacker shipping products. GsmUi is my go-to for rapid prototyping.', 'website' => 'https://kevinobrien.dev'],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                ...$userData,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($userData['name']) . '&background=random',
                'is_public' => true,
            ]);
            $user->assignRole('user');
        }
    }
}
