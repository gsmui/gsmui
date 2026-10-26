<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            ['code' => 'WELCOME20', 'type' => 'percentage', 'value' => 20, 'minimum_order_amount' => 0, 'maximum_uses' => 500, 'used_count' => 234, 'starts_at' => now()->subMonths(6), 'expires_at' => now()->addMonths(6), 'active' => true],
            ['code' => 'SAVE10', 'type' => 'fixed', 'value' => 10, 'minimum_order_amount' => 25, 'maximum_uses' => 1000, 'used_count' => 567, 'starts_at' => now()->subYear(), 'expires_at' => now()->addYear(), 'active' => true],
            ['code' => 'FLASH50', 'type' => 'percentage', 'value' => 50, 'minimum_order_amount' => 50, 'maximum_uses' => 100, 'used_count' => 89, 'starts_at' => now()->subWeek(), 'expires_at' => now()->addWeek(), 'active' => true],
            ['code' => 'CREATOR15', 'type' => 'percentage', 'value' => 15, 'minimum_order_amount' => 0, 'maximum_uses' => null, 'used_count' => 1234, 'starts_at' => now()->subMonths(3), 'expires_at' => null, 'active' => true],
            ['code' => 'HOLIDAY25', 'type' => 'fixed', 'value' => 25, 'minimum_order_amount' => 75, 'maximum_uses' => 200, 'used_count' => 156, 'starts_at' => now()->subMonth(), 'expires_at' => now()->addMonth(), 'active' => true],
            ['code' => 'BUNDLE30', 'type' => 'percentage', 'value' => 30, 'minimum_order_amount' => 100, 'maximum_uses' => 50, 'used_count' => 12, 'starts_at' => now()->subWeeks(2), 'expires_at' => now()->addMonths(2), 'active' => true],
            ['code' => 'EXPIRED5', 'type' => 'percentage', 'value' => 5, 'minimum_order_amount' => 0, 'maximum_uses' => 100, 'used_count' => 100, 'starts_at' => now()->subMonths(6), 'expires_at' => now()->subMonth(), 'active' => false],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
