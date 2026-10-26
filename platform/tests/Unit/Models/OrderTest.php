<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_belongs_to_user(): void
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(User::class, $order->user);
    }

    public function test_order_belongs_to_coupon(): void
    {
        $coupon = Coupon::factory()->create();
        $order = Order::factory()->create(['coupon_id' => $coupon->id]);

        $this->assertInstanceOf(Coupon::class, $order->coupon);
    }

    public function test_order_has_many_items(): void
    {
        $order = Order::factory()->create();
        OrderItem::factory()->count(3)->create(['order_id' => $order->id]);

        $this->assertCount(3, $order->items);
    }

    public function test_order_has_many_licenses(): void
    {
        $order = Order::factory()->create();

        $this->assertCount(0, $order->licenses);
    }

    public function test_order_status_can_be_pending(): void
    {
        $order = Order::factory()->pending()->create();

        $this->assertEquals('pending', $order->status);
        $this->assertEquals('pending', $order->payment_status);
    }

    public function test_order_status_can_be_completed(): void
    {
        $order = Order::factory()->completed()->create();

        $this->assertEquals('completed', $order->status);
        $this->assertEquals('paid', $order->payment_status);
    }

    public function test_order_with_coupon(): void
    {
        $coupon = Coupon::factory()->create();
        $order = Order::factory()->withCoupon($coupon->id)->create();

        $this->assertEquals($coupon->id, $order->coupon_id);
        $this->assertGreaterThan(0, $order->discount);
    }

    public function test_order_casts_decimals(): void
    {
        $order = Order::factory()->create([
            'subtotal' => 99.99,
            'discount' => 10.00,
            'tax' => 8.00,
            'total' => 97.99,
        ]);

        $this->assertEquals('99.99', $order->subtotal);
        $this->assertEquals('10.00', $order->discount);
        $this->assertEquals('8.00', $order->tax);
        $this->assertEquals('97.99', $order->total);
    }

    public function test_order_fillable_attributes(): void
    {
        $order = new Order();

        $this->assertContains('user_id', $order->getFillable());
        $this->assertContains('order_number', $order->getFillable());
        $this->assertContains('status', $order->getFillable());
        $this->assertContains('total', $order->getFillable());
        $this->assertContains('payment_method', $order->getFillable());
        $this->assertContains('payment_status', $order->getFillable());
    }

    public function test_order_has_notes_field(): void
    {
        $order = Order::factory()->create(['notes' => 'Please ship quickly']);

        $this->assertEquals('Please ship quickly', $order->notes);
    }

    public function test_order_has_payment_method(): void
    {
        $order = Order::factory()->create(['payment_method' => 'stripe']);

        $this->assertEquals('stripe', $order->payment_method);
    }
}
