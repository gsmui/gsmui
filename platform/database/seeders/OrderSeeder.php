<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\MarketplaceProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->pluck('id')->toArray();
        $products = MarketplaceProduct::where('status', 'published')->get();
        $coupon = Coupon::where('code', 'WELCOME20')->first();

        if (empty($users)) {
            $users = [User::first()->id];
        }

        $paymentMethods = ['credit_card', 'paypal', 'stripe', 'bank_transfer'];
        $statuses = ['pending', 'processing', 'completed', 'refunded', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];

        for ($i = 0; $i < 35; $i++) {
            $userId = $users[array_rand($users)];
            $subtotal = fake()->randomFloat(2, 19, 499);
            $useCoupon = $coupon && fake()->boolean(25);
            $discount = $useCoupon ? round($subtotal * 0.2, 2) : 0;
            $tax = round(($subtotal - $discount) * 0.1, 2);
            $total = round($subtotal - $discount + $tax, 2);

            $status = fake()->randomElement($statuses);
            $paymentStatus = match ($status) {
                'completed' => 'paid',
                'refunded' => 'refunded',
                'cancelled' => 'failed',
                default => fake()->randomElement($paymentStatuses),
            };

            $order = Order::create([
                'user_id' => $userId,
                'order_number' => 'ORD-' . strtoupper(fake()->bothify('??-#####')),
                'status' => $status,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'coupon_id' => $useCoupon ? $coupon->id : null,
                'payment_method' => fake()->randomElement($paymentMethods),
                'payment_status' => $paymentStatus,
                'notes' => fake()->optional(30)->sentence(),
            ]);

            $itemCount = fake()->numberBetween(1, 3);
            $selectedProducts = $products->random(min($itemCount, $products->count()));

            foreach ($selectedProducts as $product) {
                $quantity = fake()->numberBetween(1, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'total' => round($product->price * $quantity, 2),
                    'license_key' => $product->type === 'digital' ? 'GSMUI-' . strtoupper(fake()->bothify('????-????-????')) : null,
                ]);
            }
        }
    }
}
