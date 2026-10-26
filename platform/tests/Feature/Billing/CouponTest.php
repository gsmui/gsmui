<?php

declare(strict_types=1);

namespace Tests\Feature\Billing;

use Tests\TestCase;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_apply_valid_coupon(): void
    {
        $user = $this->createUser();
        $coupon = Coupon::factory()->active()->percentage()->create([
            'code' => 'SAVE20',
            'value' => 20,
            'minimum_order_amount' => 0,
        ]);
        $this->actingAs($user);

        $response = $this->post('/dashboard/coupons/apply', [
            'code' => 'SAVE20',
        ]);

        $response->assertSessionHas('coupon_id');
    }

    public function test_user_cannot_apply_invalid_coupon(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->post('/dashboard/coupons/apply', [
            'code' => 'INVALID',
        ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_user_cannot_apply_expired_coupon(): void
    {
        $user = $this->createUser();
        $coupon = Coupon::factory()->create([
            'code' => 'EXPIRED',
            'active' => true,
            'expires_at' => now()->subDay(),
        ]);
        $this->actingAs($user);

        $response = $this->post('/dashboard/coupons/apply', [
            'code' => 'EXPIRED',
        ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_user_cannot_apply_inactive_coupon(): void
    {
        $user = $this->createUser();
        $coupon = Coupon::factory()->create([
            'code' => 'INACTIVE',
            'active' => false,
        ]);
        $this->actingAs($user);

        $response = $this->post('/dashboard/coupons/apply', [
            'code' => 'INACTIVE',
        ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_user_cannot_apply_coupon_with_minimum_order_not_met(): void
    {
        $user = $this->createUser();
        $coupon = Coupon::factory()->active()->create([
            'code' => 'MIN100',
            'minimum_order_amount' => 100,
        ]);
        $this->actingAs($user);

        $response = $this->post('/dashboard/coupons/apply', [
            'code' => 'MIN100',
        ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_user_can_remove_coupon(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->delete('/dashboard/coupons/remove');

        $response->assertSessionMissing('coupon_id');
    }

    public function test_coupon_is_valid_when_active_and_within_dates(): void
    {
        $coupon = Coupon::factory()->active()->create([
            'starts_at' => now()->subMonth(),
            'expires_at' => now()->addMonth(),
        ]);

        $this->assertTrue($coupon->isValid());
    }

    public function test_coupon_is_invalid_when_expired(): void
    {
        $coupon = Coupon::factory()->create([
            'active' => true,
            'starts_at' => now()->subMonths(2),
            'expires_at' => now()->subDay(),
        ]);

        $this->assertFalse($coupon->isValid());
    }

    public function test_coupon_is_invalid_when_max_uses_reached(): void
    {
        $coupon = Coupon::factory()->create([
            'active' => true,
            'starts_at' => now()->subMonth(),
            'expires_at' => now()->addMonth(),
            'maximum_uses' => 10,
            'used_count' => 10,
        ]);

        $this->assertFalse($coupon->isValid());
    }

    public function test_percentage_coupon_calculates_correct_discount(): void
    {
        $coupon = Coupon::factory()->percentage()->create([
            'value' => 20,
        ]);

        $this->assertEquals('percentage', $coupon->type);
        $this->assertEquals(20, $coupon->value);
    }

    public function test_fixed_coupon_has_fixed_value(): void
    {
        $coupon = Coupon::factory()->fixed()->create([
            'value' => 15,
        ]);

        $this->assertEquals('fixed', $coupon->type);
        $this->assertEquals(15, $coupon->value);
    }
}
