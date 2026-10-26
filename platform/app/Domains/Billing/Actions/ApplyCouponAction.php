<?php

declare(strict_types=1);

namespace App\Domains\Billing\Actions;

use App\Domains\Billing\Models\Coupon;
use App\Domains\Users\Models\User;
use Illuminate\Validation\ValidationException;

class ApplyCouponAction
{
    public function execute(User $user, string $couponCode, float $amount): array
    {
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            throw ValidationException::withMessages([
                'coupon' => 'Invalid coupon code.',
            ]);
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            throw ValidationException::withMessages([
                'coupon' => 'This coupon has expired.',
            ]);
        }

        if ($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit) {
            throw ValidationException::withMessages([
                'coupon' => 'This coupon has reached its usage limit.',
            ]);
        }

        if ($coupon->min_amount && $amount < $coupon->min_amount) {
            throw ValidationException::withMessages([
                'coupon' => "Minimum order amount is $" . number_format($coupon->min_amount, 2),
            ]);
        }

        $discount = $coupon->type === 'percentage'
            ? $amount * ($coupon->value / 100)
            : min($coupon->value, $amount);

        $coupon->increment('usage_count');

        return [
            'coupon' => $coupon,
            'discount' => $discount,
            'final_amount' => $amount - $discount,
        ];
    }
}
