<?php

declare(strict_types=1);

namespace Tests\Feature\Billing;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_payment_history(): void
    {
        $user = $this->createUser();
        Order::factory()->count(3)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get('/dashboard/payments');

        $response->assertStatus(200);
    }

    public function test_payment_history_requires_authentication(): void
    {
        $response = $this->get('/dashboard/payments');

        $response->assertRedirect('/login');
    }

    public function test_webhook_endpoint_is_accessible(): void
    {
        $response = $this->post('/webhook/payment', [
            'event' => 'payment.completed',
            'data' => ['id' => 'pay_123'],
        ]);

        $response->assertStatus(200);
    }

    public function test_webhook_verifies_signature(): void
    {
        $response = $this->post('/webhook/payment', [
            'event' => 'payment.completed',
            'data' => ['id' => 'pay_123'],
        ], [
            'Stripe-Signature' => 'invalid-signature',
        ]);

        $response->assertStatus(400);
    }

    public function test_payment_processing_stores_order(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/dashboard/payments/process', [
            'amount' => 29.99,
            'currency' => 'usd',
            'payment_method' => 'stripe',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
        ]);
    }

    public function test_payment_can_be_refunded(): void
    {
        $user = $this->createUser();
        $order = Order::factory()->completed()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->post("/dashboard/payments/{$order->id}/refund");

        $order->refresh();
        $this->assertEquals('refunded', $order->status);
        $this->assertEquals('refunded', $order->payment_status);
    }

    public function test_user_cannot_refund_other_users_payment(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $order = Order::factory()->completed()->create(['user_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->post("/dashboard/payments/{$order->id}/refund");

        $response->assertStatus(403);
    }
}
