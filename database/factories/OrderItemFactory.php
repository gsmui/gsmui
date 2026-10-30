<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MarketplaceProduct;
use App\Domains\Marketplace\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $price = fake()->randomFloat(2, 9, 299);
        $quantity = fake()->numberBetween(1, 3);

        return [
            'order_id' => Order::factory(),
            'product_id' => MarketplaceProduct::factory(),
            'product_name' => fake()->words(3, true),
            'quantity' => $quantity,
            'price' => $price,
            'total' => round($price * $quantity, 2),
            'license_key' => fake()->optional(70)->bothify('GSMUI-????-????-????'),
        ];
    }
}
