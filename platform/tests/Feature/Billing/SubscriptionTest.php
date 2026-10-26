<?php

declare(strict_types=1);

namespace Tests\Feature\Billing;

use Tests\TestCase;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_subscription_page(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->get('/dashboard/subscription');

        $response->assertStatus(200);
    }

    public function test_subscription_requires_authentication(): void
    {
        $response = $this->get('/dashboard/subscription');

        $response->assertRedirect('/login');
    }

    public function test_user_can_create_subscription(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/dashboard/subscription', [
            'plan' => 'pro',
            'payment_method' => 'stripe',
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'pro',
        ]);
    }

    public function test_user_can_cancel_subscription(): void
    {
        $user = $this->createUser();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'plan' => 'pro',
            'status' => 'active',
        ]);
        $this->actingAs($user);

        $response = $this->delete('/dashboard/subscription');

        $subscription->refresh();
        $this->assertEquals('cancelled', $subscription->status);
        $this->assertNotNull($subscription->cancelled_at);
    }

    public function test_user_can_upgrade_subscription(): void
    {
        $user = $this->createUser();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'plan' => 'pro',
            'status' => 'active',
        ]);
        $this->actingAs($user);

        $response = $this->put('/dashboard/subscription', [
            'plan' => 'enterprise',
        ]);

        $subscription->refresh();
        $this->assertEquals('enterprise', $subscription->plan);
    }

    public function test_subscription_has_correct_plan(): void
    {
        $user = $this->createUser();
        Subscription::factory()->create([
            'user_id' => $user->id,
            'plan' => 'pro',
        ]);

        $this->assertTrue($user->isPro());
    }

    public function test_subscription_is_active(): void
    {
        $user = $this->createUser();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
            'ends_at' => now()->addMonth(),
        ]);

        $this->assertTrue($subscription->isActive());
    }

    public function test_subscription_can_be_expired(): void
    {
        $user = $this->createUser();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'active',
            'ends_at' => now()->subDay(),
        ]);

        $this->assertTrue($subscription->isExpired());
        $this->assertFalse($subscription->isActive());
    }

    public function test_subscription_can_be_trialing(): void
    {
        $user = $this->createUser();
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => 'trialing',
            'trial_ends_at' => now()->addDays(14),
        ]);

        $this->assertEquals('trialing', $subscription->status);
        $this->assertNotNull($subscription->trial_ends_at);
    }
}
