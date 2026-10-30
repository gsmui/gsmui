<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Coupon;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = \App\Domains\Marketplace\Models\Order::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 19, 499);
        $discount = fake()->randomFloat(2, 0, $subtotal * 0.3);
        $tax = ($subtotal - $discount) * 0.1;

        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-' . strtoupper(fake()->bothify('??-#####')),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'refunded', 'cancelled']),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => round($tax, 2),
            'total' => round($subtotal - $discount + $tax, 2),
            'coupon_id' => null,
            'payment_method' => fake()->randomElement(['credit_card', 'paypal', 'stripe', 'bank_transfer']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'notes' => fake()->optional(30)->sentence(),
        ];
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);
    }

    public function withCoupon(?int $couponId = null): static
    {
        return $this->state(fn () => [
            'coupon_id' => $couponId,
            'discount' => fake()->randomFloat(2, 5, 50),
        ]);
    }
}
