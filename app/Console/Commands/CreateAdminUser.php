<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domains\Users\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {name} {email} {password}';
    protected $description = 'Create an admin user';

    public function handle(): int
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => now(),
        ]);

        $user->assignRole('admin');

        $this->info("Admin user created: {$email}");

        return Command::SUCCESS;
    }
}
