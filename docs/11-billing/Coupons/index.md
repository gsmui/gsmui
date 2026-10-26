# Coupon System

## Overview

Coupons provide discounts on products and subscriptions. This document covers coupon types, restrictions, usage limits, stacking rules, and analytics.

## Coupon Types

| Type | Description | Example |
|------|-------------|---------|
| `percentage` | Percentage off | 20% off |
| `fixed` | Fixed amount off | $10 off |
| `free_trial` | Extended trial | 30-day free trial |
| `free_shipping` | Shipping discount | Free shipping |
| `buy_x_get_y` | Buy X get Y free | Buy 2 get 1 free |

### Coupon Model

```php
class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'currency',
        'max_uses', 'max_uses_per_user',
        'min_order_amount', 'product_ids',
        'starts_at', 'expires_at',
        'is_active', 'metadata',
    ];

    protected $casts = [
        'value' => 'integer',
        'product_ids' => 'array',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }
}
```

### Coupon Properties

| Property | Type | Description |
|----------|------|-------------|
| `code` | `string` | Unique code customers enter |
| `type` | `enum` | percentage, fixed, free_trial, free_shipping |
| `value` | `int` | Discount amount (cents for fixed, basis points for %) |
| `currency` | `string?` | Currency restriction (null = all) |
| `max_uses` | `int?` | Total usage limit (null = unlimited) |
| `max_uses_per_user` | `int?` | Per-user limit |
| `min_order_amount` | `int?` | Minimum order to apply |
| `product_ids` | `array?` | Applicable products (null = all) |
| `starts_at` | `datetime?` | Activation time |
| `expires_at` | `datetime?` | Expiration time |

## Coupon Application

### Applying Coupons

```php
class CouponService
{
    public function apply(string $code, Order $order): CouponResult
    {
        $coupon = $this->resolve($code);
        $this->validate($coupon, $order);

        $discount = $this->calculateDiscount($coupon, $order);

        $order->update([
            'coupon_code' => $coupon->code,
            'discount' => $discount,
            'total' => $order->subtotal - $discount + $order->tax,
        ]);

        $this->recordUsage($coupon, $order);

        event(new CouponApplied($coupon, $order));

        return new CouponResult(
            coupon: $coupon,
            discount: $discount,
            newTotal: $order->total,
        );
    }

    protected function resolve(string $code): Coupon
    {
        $coupon = Coupon::where('code', strtoupper($code))
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            throw new CouponNotFoundException("Invalid coupon code.");
        }

        return $coupon;
    }

    protected function validate(Coupon $coupon, Order $order): void
    {
        if ($coupon->starts_at && $coupon->starts_at->isFuture()) {
            throw new CouponNotActiveException("This coupon is not active yet.");
        }

        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            throw new CouponExpiredException("This coupon has expired.");
        }

        if ($coupon->max_uses && $coupon->usages()->count() >= $coupon->max_uses) {
            throw new CouponLimitReachedException("This coupon has reached its usage limit.");
        }

        if ($coupon->max_uses_per_user) {
            $userUsage = $coupon->usages()
                ->where('user_id', $order->user_id)
                ->count();

            if ($userUsage >= $coupon->max_uses_per_user) {
                throw new CouponLimitReachedException("You have already used this coupon.");
            }
        }

        if ($coupon->min_order_amount && $order->subtotal < $coupon->min_order_amount) {
            throw new MinimumNotMetException(
                "Minimum order amount is " . money($coupon->min_order_amount)
            );
        }

        if ($coupon->product_ids) {
            $applicableItems = $order->items()
                ->whereIn('product_id', $coupon->product_ids)
                ->sum('total');

            if ($applicableItems === 0) {
                throw new CouponNotApplicableException("This coupon is not valid for your order.");
            }
        }
    }

    protected function calculateDiscount(Coupon $coupon, Order $order): int
    {
        $applicableAmount = $coupon->product_ids
            ? $order->items()->whereIn('product_id', $coupon->product_ids)->sum('total')
            : $order->subtotal;

        return match ($coupon->type) {
            'percentage' => (int) ($applicableAmount * $coupon->value / 10000),
            'fixed' => min($coupon->value, $applicableAmount),
            'free_trial' => 0,
            'free_shipping' => $order->shipping ?? 0,
            default => 0,
        };
    }
}
```

## Restrictions

### Restriction Types

| Restriction | Description | Example |
|-------------|-------------|---------|
| `product` | Specific products only | Pro plan only |
| `category` | Product categories | All digital products |
| `user` | Specific users | New customers only |
| `role` | User roles | Enterprise customers |
| `first_order` | First order only | Welcome discount |
| `subscription` | Active subscribers | Renewal discount |
| `minimum_order` | Minimum spend | Orders over $50 |

### Applying Restrictions

```php
class CouponRestrictionChecker
{
    public function check(Coupon $coupon, User $user, Order $order): array
    {
        $violations = [];

        if ($coupon->first_order_only && $user->orders()->count() > 0) {
            $violations[] = 'First order only';
        }

        if ($coupon->role_restriction) {
            $allowedRoles = (array) $coupon->role_restriction;
            if (!$user->hasAnyRole($allowedRoles)) {
                $violations[] = 'Not eligible for your role';
            }
        }

        if ($coupon->subscription_only && !$user->activeSubscription()) {
            $violations[] = 'Active subscription required';
        }

        return $violations;
    }
}
```

## Usage Limits

### Tracking Usage

```php
class CouponUsage extends Model
{
    protected $fillable = [
        'coupon_id', 'user_id', 'order_id',
        'discount_amount', 'metadata',
    ];

    protected $casts = [
        'discount_amount' => 'integer',
        'metadata' => 'array',
    ];
}

class CouponUsageTracker
{
    public function record(Coupon $coupon, Order $order): void
    {
        CouponUsage::create([
            'coupon_id' => $coupon->id,
            'user_id' => $order->user_id,
            'order_id' => $order->id,
            'discount_amount' => $order->discount,
        ]);
    }

    public function getRemainingUses(Coupon $coupon): ?int
    {
        if (!$coupon->max_uses) {
            return null; // unlimited
        }

        $used = $coupon->usages()->count();
        return max(0, $coupon->max_uses - $used);
    }

    public function getUserRemainingUses(Coupon $coupon, User $user): ?int
    {
        if (!$coupon->max_uses_per_user) {
            return null;
        }

        $used = $coupon->usages()->where('user_id', $user->id)->count();
        return max(0, $coupon->max_uses_per_user - $used);
    }
}
```

## Stacking Rules

### Stacking Configuration

```php
// config/coupons.php
return [
    'stacking' => [
        'enabled' => false,
        'max_coupons' => 1,
        'priority' => 'highest_discount',
        'exclusive_types' => ['free_shipping'],
    ],
];
```

### Stacking Logic

```php
class CouponStackingService
{
    public function resolve(array $coupons, Order $order): array
    {
        if (!config('coupons.stacking.enabled')) {
            return [$this->selectBest($coupons, $order)];
        }

        $maxCoupons = config('coupons.stacking.max_coupons');
        $resolved = [];

        foreach ($coupons as $coupon) {
            if (count($resolved) >= $maxCoupons) {
                break;
            }

            if ($this->isExclusive($coupon)) {
                return [$coupon]; // exclusive coupons can't stack
            }

            $resolved[] = $coupon;
        }

        return $resolved;
    }

    protected function selectBest(array $coupons, Order $order): Coupon
    {
        return collect($coupons)
            ->map(fn ($coupon) => [
                'coupon' => $coupon,
                'discount' => $this->calculateDiscount($coupon, $order),
            ])
            ->sortByDesc('discount')
            ->first()['coupon'];
    }
}
```

## Analytics

### Coupon Analytics

```php
class CouponAnalytics
{
    public function getStats(Coupon $coupon): array
    {
        return [
            'total_uses' => $coupon->usages()->count(),
            'unique_users' => $coupon->usages()->distinct('user_id')->count(),
            'total_discount' => $coupon->usages()->sum('discount_amount'),
            'average_discount' => $coupon->usages()->avg('discount_amount'),
            'conversion_rate' => $this->conversionRate($coupon),
            'revenue_impact' => $this->revenueImpact($coupon),
        ];
    }

    protected function conversionRate(Coupon $coupon): float
    {
        $views = Cache::get("coupon:{$coupon->code}:views", 0);
        $uses = $coupon->usages()->count();

        return $views > 0 ? ($uses / $views) * 100 : 0;
    }

    protected function revenueImpact(Coupon $coupon): int
    {
        $orders = Order::where('coupon_code', $coupon->code)
            ->where('status', '!=', 'refunded')
            ->sum('total');

        $discounts = $coupon->usages()->sum('discount_amount');

        return $orders - $discounts;
    }
}
```

## Database Schema

### Coupons Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `code` | `string` | Unique |
| `type` | `enum` | percentage / fixed / free_trial / free_shipping |
| `value` | `int` | |
| `currency` | `string?` | |
| `max_uses` | `int?` | |
| `max_uses_per_user` | `int?` | |
| `min_order_amount` | `int?` | |
| `product_ids` | `json?` | |
| `starts_at` | `timestamp?` | |
| `expires_at` | `timestamp?` | |
| `is_active` | `bool` | |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Generate unique codes** — random strings are harder to guess
2. **Set expiration dates** — prevents indefinite discount abuse
3. **Track usage** — know which coupons drive revenue
4. **Limit stacking** — prevent excessive discounting
5. **Test with Playwright** — verify coupon application in checkout
6. **A/B test coupon values** — optimize discount percentages
