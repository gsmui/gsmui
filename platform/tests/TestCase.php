<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

abstract class TestCase extends BaseTestCase
{
    use BaseTestCase {
        BaseTestCase::setUp as baseSetUp;
    }

    protected function setUp(): void
    {
        $this->baseSetUp();
        $this->withoutVite();
    }

    protected function createAdmin(): User
    {
        $user = User::factory()->create();
        Role::findOrCreate('admin', 'web');
        $user->assignRole('admin');
        return $user;
    }

    protected function createEditor(): User
    {
        $user = User::factory()->create();
        Role::findOrCreate('editor', 'web');
        $user->assignRole('editor');
        return $user;
    }

    protected function createUser(): User
    {
        $user = User::factory()->create();
        Role::findOrCreate('user', 'web');
        $user->assignRole('user');
        return $user;
    }

    protected function seedRoles(): void
    {
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('editor', 'web');
        Role::findOrCreate('user', 'web');
    }
}
