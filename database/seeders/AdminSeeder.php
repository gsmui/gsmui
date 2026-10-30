<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domains\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@gsmui.dev',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'bio' => 'Platform super administrator with full system access.',
            'is_public' => false,
        ]);
        $superAdmin->assignRole('super_admin');

        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gsmui.dev',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'bio' => 'Platform administrator managing content and users.',
            'website' => 'https://gsmui.dev',
            'github_username' => 'gsmui-admin',
        ]);
        $admin->assignRole('admin');

        $moderator = User::create([
            'name' => 'Moderator',
            'username' => 'moderator',
            'email' => 'moderator@gsmui.dev',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'bio' => 'Community moderator helping users and reviewing submissions.',
        ]);
        $moderator->assignRole('admin');
    }
}
