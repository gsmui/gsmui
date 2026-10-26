<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Component;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\ApiKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_roles_relationship(): void
    {
        $user = User::factory()->create();
        Role::findOrCreate('admin', 'web');
        $user->assignRole('admin');

        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->isAdmin());
    }

    public function test_user_has_favorites_relationship(): void
    {
        $user = User::factory()->create();
        $component = Component::factory()->create();
        $user->favorites()->attach($component->id);

        $this->assertCount(1, $user->favorites);
        $this->assertEquals($component->id, $user->favorites->first()->id);
    }

    public function test_user_has_api_keys_relationship(): void
    {
        $user = User::factory()->create();
        ApiKey::factory()->count(3)->create(['user_id' => $user->id]);

        $this->assertCount(3, $user->apiKeys);
    }

    public function test_user_has_subscription_relationship(): void
    {
        $user = User::factory()->create();
        Subscription::factory()->create(['user_id' => $user->id]);

        $this->assertNotNull($user->subscription);
    }

    public function test_user_has_invoices_relationship(): void
    {
        $user = User::factory()->create();
        Invoice::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->invoices);
    }

    public function test_user_is_admin_returns_true_when_admin(): void
    {
        $user = User::factory()->create();
        Role::findOrCreate('admin', 'web');
        $user->assignRole('admin');

        $this->assertTrue($user->isAdmin());
    }

    public function test_user_is_admin_returns_false_when_not_admin(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isAdmin());
    }

    public function test_user_is_pro_returns_true_when_pro_subscription(): void
    {
        $user = User::factory()->create();
        Subscription::factory()->create(['user_id' => $user->id, 'plan' => 'pro']);

        $this->assertTrue($user->isPro());
    }

    public function test_user_is_pro_returns_false_without_subscription(): void
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isPro());
    }

    public function test_user_is_enterprise_returns_true_when_enterprise_subscription(): void
    {
        $user = User::factory()->create();
        Subscription::factory()->create(['user_id' => $user->id, 'plan' => 'enterprise']);

        $this->assertTrue($user->isEnterprise());
    }

    public function test_user_get_route_key_name_returns_username(): void
    {
        $user = User::factory()->create();

        $this->assertEquals('username', $user->getRouteKeyName());
    }

    public function test_user_is_hidden_contains_sensitive_fields(): void
    {
        $user = User::factory()->create();

        $this->assertContains('password', $user->getHidden());
        $this->assertContains('remember_token', $user->getHidden());
        $this->assertContains('two_factor_secret', $user->getHidden());
    }

    public function test_user_password_is_hashed(): void
    {
        $user = User::factory()->create(['password' => 'test-password']);

        $this->assertNotEquals('test-password', $user->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('test-password', $user->password));
    }

    public function test_user_has_profile_relationship(): void
    {
        $user = User::factory()->create();
        $this->assertNull($user->profile);
    }

    public function test_user_has_projects_relationship(): void
    {
        $user = User::factory()->create();

        $this->assertCount(0, $user->projects);
    }

    public function test_user_fillable_attributes(): void
    {
        $user = new User();

        $this->assertContains('name', $user->getFillable());
        $this->assertContains('email', $user->getFillable());
        $this->assertContains('username', $user->getFillable());
        $this->assertContains('password', $user->getFillable());
        $this->assertContains('bio', $user->getFillable());
    }
}
