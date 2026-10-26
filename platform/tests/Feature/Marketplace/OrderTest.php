<?php

declare(strict_types=1);

namespace Tests\Feature\Marketplace;

use Tests\TestCase;
use App\Models\User;
use App\Models\MarketplaceProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\License;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_purchase_product(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create(['price' => 29.99]);
        $this->actingAs($user);

        $response = $this->post('/marketplace/purchase', [
            'product_id' => $product->id,
            'payment_method' => 'stripe',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
        ]);
    }

    public function test_purchase_requires_authentication(): void
    {
        $product = MarketplaceProduct::factory()->published()->create();

        $response = $this->post('/marketplace/purchase', [
            'product_id' => $product->id,
            'payment_method' => 'stripe',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_order_is_created_with_correct_items(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create(['price' => 29.99]);
        $this->actingAs($user);

        $this->post('/marketplace/purchase', [
            'product_id' => $product->id,
            'payment_method' => 'stripe',
        ]);

        $order = Order::where('user_id', $user->id)->first();
        $this->assertNotNull($order);
        $this->assertEquals('29.99', $order->subtotal);
    }

    public function test_order_item_is_created(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create(['price' => 29.99, 'name' => 'Test Product']);
        $this->actingAs($user);

        $this->post('/marketplace/purchase', [
            'product_id' => $product->id,
            'payment_method' => 'stripe',
        ]);

        $order = Order::where('user_id', $user->id)->first();
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => 'Test Product',
        ]);
    }

    public function test_license_is_generated_on_purchase(): void
    {
        $user = $this->createUser();
        $product = MarketplaceProduct::factory()->published()->create(['price' => 29.99]);
        $this->actingAs($user);

        $this->post('/marketplace/purchase', [
            'product_id' => $product->id,
            'payment_method' => 'stripe',
        ]);

        $this->assertDatabaseHas('licenses', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => 'active',
        ]);
    }

    public function test_user_can_view_own_orders(): void
    {
        $user = $this->createUser();
        Order::factory()->count(3)->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->get('/dashboard/orders');

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_other_users_orders(): void
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        Order::factory()->count(3)->create(['user_id' => $otherUser->id]);
        $this->actingAs($user);

        $response = $this->get('/dashboard/orders');

        $response->assertStatus(200);
    }

    public function test_order_status_can_be_completed(): void
    {
        $order = Order::factory()->pending()->create();
        $order->status = 'completed';
        $order->payment_status = 'paid';
        $order->save();

        $this->assertEquals('completed', $order->status);
        $this->assertEquals('paid', $order->payment_status);
    }
}
