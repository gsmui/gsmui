# Plan Definitions

## Overview

Plans define subscription tiers with associated features, limits, and pricing. This document covers plan structure, feature gating, usage limits, and overage handling.

## Plan Tiers

| Tier | Price | Features | Limits |
|------|-------|----------|--------|
| Free | $0/mo | Basic features | 1 project, 100MB storage |
| Starter | $19/mo | Core features | 5 projects, 5GB storage |
| Pro | $49/mo | All features | 25 projects, 50GB storage |
| Enterprise | Custom | All + premium | Unlimited |

### Plan Model

```php
class Plan extends Model
{
    protected $fillable = [
        'name', 'slug', 'tier', 'price_monthly', 'price_annual',
        'currency', 'features', 'limits', 'is_active',
        'trial_period_days', 'metadata',
    ];

    protected $casts = [
        'price_monthly' => 'integer',
        'price_annual' => 'integer',
        'features' => 'array',
        'limits' => 'array',
        'metadata' => 'array',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class)->withPivot('limit');
    }
}
```

## Feature Gating

### Feature Definitions

```php
// config/plans.php
return [
    'features' => [
        'projects' => [
            'label' => 'Projects',
            'type' => 'limit',
            'free' => 1,
            'starter' => 5,
            'pro' => 25,
            'enterprise' => -1, // unlimited
        ],
        'storage' => [
            'label' => 'Storage',
            'type' => 'limit',
            'free' => 100, // MB
            'starter' => 5120,
            'pro' => 51200,
            'enterprise' => -1,
        ],
        'api_calls' => [
            'label' => 'API Calls',
            'type' => 'limit',
            'free' => 1000,
            'starter' => 10000,
            'pro' => 100000,
            'enterprise' => -1,
        ],
        'team_members' => [
            'label' => 'Team Members',
            'type' => 'limit',
            'free' => 1,
            'starter' => 3,
            'pro' => 15,
            'enterprise' => -1,
        ],
        'custom_domain' => [
            'label' => 'Custom Domain',
            'type' => 'boolean',
            'free' => false,
            'starter' => true,
            'pro' => true,
            'enterprise' => true,
        ],
        'priority_support' => [
            'label' => 'Priority Support',
            'type' => 'boolean',
            'free' => false,
            'starter' => false,
            'pro' => true,
            'enterprise' => true,
        ],
        'analytics' => [
            'label' => 'Advanced Analytics',
            'type' => 'boolean',
            'free' => false,
            'starter' => true,
            'pro' => true,
            'enterprise' => true,
        ],
        'sso' => [
            'label' => 'SSO Integration',
            'type' => 'boolean',
            'free' => false,
            'starter' => false,
            'pro' => false,
            'enterprise' => true,
        ],
    ],
];
```

### Feature Checking

```php
class FeatureGate
{
    public function allows(User $user, string $feature): bool
    {
        $plan = $user->currentPlan();
        $limit = config("plans.features.{$feature}.{$plan->tier}");

        if ($limit === -1) {
            return true; // unlimited
        }

        if (is_bool($limit)) {
            return $limit;
        }

        $usage = $this->getUsage($user, $feature);
        return $usage < $limit;
    }

    public function getRemaining(User $user, string $feature): ?int
    {
        $plan = $user->currentPlan();
        $limit = config("plans.features.{$feature}.{$plan->tier}");

        if ($limit === -1) {
            return null; // unlimited
        }

        $usage = $this->getUsage($user, $feature);
        return max(0, $limit - $usage);
    }

    protected function getUsage(User $user, string $feature): int
    {
        return Cache::remember(
            "usage:{$user->id}:{$feature}",
            now()->addMinutes(5),
            fn () => UsageTracker::get($user, $feature)
        );
    }
}
```

### Blade Feature Gates

```php
{{-- Check feature access --}}
@can('feature', 'custom_domain')
    <div>Custom domain settings available</div>
@endcan

{{-- Show upgrade prompt --}}
@if(!PlanFeature::allows($user, 'analytics'))
    <div class="upgrade-banner">
        <p>Upgrade to Starter for advanced analytics</p>
        <a href="/pricing">View Plans</a>
    </div>
@endif

{{-- Show usage meter --}}
@php
    $remaining = PlanFeature::getRemaining($user, 'projects');
@endphp
<div>Projects: {{ $remaining }} remaining</div>
```

## Plan Limits

### Limit Types

| Type | Description | Behavior on Exceed |
|------|-------------|-------------------|
| `hard` | Cannot exceed | Block action |
| `soft` | Can exceed with overage | Charge overage fee |
| `warning` | Warn at threshold | Show warning, allow |

### Limit Configuration

```php
'limits' => [
    'projects' => [
        'type' => 'hard',
        'warning_threshold' => 0.8, // warn at 80%
        'overage_price' => null, // no overage for hard limits
    ],
    'storage' => [
        'type' => 'soft',
        'warning_threshold' => 0.9,
        'overage_price' => 500, // $5.00 per GB
        'overage_unit' => 'gb',
    ],
    'api_calls' => [
        'type' => 'soft',
        'warning_threshold' => 0.8,
        'overage_price' => 100, // $1.00 per 1000 calls
        'overage_unit' => '1000_calls',
    ],
],
```

### Limit Enforcement

```php
class LimitEnforcer
{
    public function enforce(User $user, string $resource): void
    {
        $plan = $user->currentPlan();
        $limit = $this->getLimit($plan, $resource);
        $usage = $this->getUsage($user, $resource);

        if ($limit['type'] === 'hard' && $usage >= $limit['value']) {
            throw new LimitExceededException(
                "You have reached the {$resource} limit for your {$plan->tier} plan."
            );
        }

        if ($limit['type'] === 'soft' && $usage >= $limit['value']) {
            $this->chargeOverage($user, $resource, $usage - $limit['value']);
        }

        if ($usage >= $limit['value'] * $limit['warning_threshold']) {
            $this->sendWarning($user, $resource, $usage, $limit['value']);
        }
    }
}
```

## Overage Pricing

### Overage Calculation

```php
class OverageCalculator
{
    public function calculate(User $user, string $resource, int $quantity): int
    {
        $plan = $user->currentPlan();
        $limit = config("plans.limits.{$resource}");
        $price = $limit['overage_price'];
        $unit = $limit['overage_unit'];

        $units = $this->convertToUnits($quantity, $unit);

        return $units * $price;
    }

    protected function convertToUnits(int $quantity, string $unit): int
    {
        return match ($unit) {
            'gb' => (int) ceil($quantity / (1024 * 1024 * 1024)),
            '1000_calls' => (int) ceil($quantity / 1000),
            'per_unit' => $quantity,
            default => $quantity,
        };
    }
}
```

### Overage Billing

```php
class OverageBiller
{
    public function billOverages(User $user): void
    {
        $resources = ['storage', 'api_calls'];

        foreach ($resources as $resource) {
            $usage = UsageTracker::get($user, $resource, period: 'current_month');
            $limit = $this->getLimit($user, $resource);
            $overage = max(0, $usage - $limit);

            if ($overage > 0) {
                $amount = OverageCalculator::calculate($user, $resource, $overage);

                Invoice::createOverage($user, $resource, $overage, $amount);
            }
        }
    }
}
```

## Plan Database Schema

### Plans Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | |
| `slug` | `string` | Unique |
| `tier` | `enum` | free / starter / pro / enterprise |
| `price_monthly` | `bigint` | In cents |
| `price_annual` | `bigint` | In cents |
| `currency` | `string` | ISO 4217 |
| `features` | `json` | Feature access map |
| `limits` | `json` | Resource limits |
| `trial_period_days` | `int?` | |
| `is_active` | `bool` | |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Keep plan count low** — 3-4 tiers is optimal for decision-making
2. **Make Free tier useful** — users should experience value before upgrading
3. **Use soft limits for revenue** — overages generate incremental revenue
4. **Warn before limits** — proactive warnings reduce support tickets
5. **Version plan features** — never remove features from existing subscribers
6. **Enterprise plans are custom** — don't publish pricing, handle sales-led
