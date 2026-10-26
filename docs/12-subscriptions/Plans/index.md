# Subscription Plans

## Overview

Subscription plans define recurring billing tiers with associated features, pricing, and trial periods. This document covers plan features, pricing models, trial management, and annual vs monthly billing.

## Plan Structure

```php
class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'status',
        'price_monthly', 'price_annual', 'currency',
        'trial_days', 'features', 'limits',
        'metadata',
    ];

    protected $casts = [
        'price_monthly' => 'integer',
        'price_annual' => 'integer',
        'trial_days' => 'int',
        'features' => 'array',
        'limits' => 'array',
        'metadata' => 'array',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
```

## Plan Features

### Feature Definition

```php
'features' => [
    'projects' => ['limit' => 10, 'label' => 'Projects'],
    'storage' => ['limit' => 5368709120, 'label' => '5 GB Storage'], // bytes
    'api_calls' => ['limit' => 10000, 'label' => '10,000 API Calls/mo'],
    'team_members' => ['limit' => 5, 'label' => '5 Team Members'],
    'custom_domain' => ['enabled' => true, 'label' => 'Custom Domain'],
    'priority_support' => ['enabled' => true, 'label' => 'Priority Support'],
    'analytics' => ['enabled' => true, 'label' => 'Advanced Analytics'],
    'sso' => ['enabled' => false, 'label' => 'SSO Integration'],
    'white_label' => ['enabled' => false, 'label' => 'White Label'],
    'dedicated_support' => ['enabled' => false, 'label' => 'Dedicated Support'],
],
```

### Feature Access Check

```php
class PlanFeatureService
{
    public function allows(Subscription $subscription, string $feature): bool
    {
        $plan = $subscription->plan;
        $featureConfig = $plan->features[$feature] ?? null;

        if (!$featureConfig) {
            return false;
        }

        if (isset($featureConfig['enabled'])) {
            return $featureConfig['enabled'];
        }

        return true;
    }

    public function getLimit(Subscription $subscription, string $feature): ?int
    {
        $plan = $subscription->plan;
        return $plan->features[$feature]['limit'] ?? null;
    }

    public function getUsage(Subscription $subscription, string $feature): int
    {
        return Cache::remember(
            "usage:{$subscription->id}:{$feature}",
            now()->addMinutes(5),
            fn () => $this->calculateUsage($subscription, $feature)
        );
    }

    public function getRemaining(Subscription $subscription, string $feature): ?int
    {
        $limit = $this->getLimit($subscription, $feature);

        if ($limit === null) {
            return null; // unlimited
        }

        $usage = $this->getUsage($subscription, $feature);
        return max(0, $limit - $usage);
    }
}
```

## Pricing Models

| Model | Description | Use Case |
|-------|-------------|----------|
| Flat | Fixed monthly/annual price | Most SaaS products |
| Per-seat | Price per team member | Collaboration tools |
| Usage-based | Pay per API call/transaction | API services |
| Tiered | Volume discounts | Scaling services |
| Hybrid | Base + usage overage | Platform services |

### Pricing Table

| Plan | Monthly | Annual | Annual Savings | Trial |
|------|---------|--------|----------------|-------|
| Free | $0 | $0 | — | — |
| Starter | $19/mo | $190/yr | 17% | 14 days |
| Pro | $49/mo | $490/yr | 17% | 14 days |
| Business | $99/mo | $990/yr | 17% | 30 days |
| Enterprise | Custom | Custom | Negotiable | Custom |

### Pricing Configuration

```php
return [
    'plans' => [
        'starter' => [
            'name' => 'Starter',
            'price_monthly' => 1900, // $19.00
            'price_annual' => 19000, // $190.00
            'trial_days' => 14,
        ],
        'pro' => [
            'name' => 'Pro',
            'price_monthly' => 4900, // $49.00
            'price_annual' => 49000, // $490.00
            'trial_days' => 14,
        ],
        'business' => [
            'name' => 'Business',
            'price_monthly' => 9900, // $99.00
            'price_annual' => 99000, // $990.00
            'trial_days' => 30,
        ],
    ],
];
```

## Trial Periods

### Trial Configuration

```php
'trial' => [
    'enabled' => true,
    'default_days' => 14,
    'max_extensions' => 1,
    'extension_days' => 7,
    'require_credit_card' => false,
    'send_reminders' => true,
    'reminder_days_before' => [3, 1],
],
```

### Trial Management

```php
class TrialService
{
    public function start(User $user, SubscriptionPlan $plan): Subscription
    {
        if (!$plan->trial_days) {
            throw new NoTrialAvailableException('This plan does not offer a trial.');
        }

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'trialing',
            'trial_ends_at' => now()->addDays($plan->trial_days),
            'billing_cycle' => 'monthly',
        ]);

        event(new TrialStarted($subscription));

        return $subscription;
    }

    public function convert(Subscription $subscription): void
    {
        $subscription->update([
            'status' => 'active',
            'trial_ends_at' => null,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);

        event(new TrialConverted($subscription));
    }

    public function extend(Subscription $subscription, int $days = 7): void
    {
        $subscription->update([
            'trial_ends_at' => $subscription->trial_ends_at->addDays($days),
        ]);

        event(new TrialExtended($subscription, $days));
    }
}
```

## Annual vs Monthly

### Billing Cycle Management

```php
class BillingCycleService
{
    public function getRenewalDate(Subscription $subscription): Carbon
    {
        return match ($subscription->billing_cycle) {
            'monthly' => $subscription->ends_at,
            'annual' => $subscription->ends_at,
            default => $subscription->ends_at,
        };
    }

    public function getPrice(Subscription $subscription): int
    {
        $plan = $subscription->plan;

        return match ($subscription->billing_cycle) {
            'monthly' => $plan->price_monthly,
            'annual' => $plan->price_annual,
            default => $plan->price_monthly,
        };
    }

    public function switchBillingCycle(Subscription $subscription, string $newCycle): void
    {
        $oldCycle = $subscription->billing_cycle;

        if ($oldCycle === $newCycle) {
            return;
        }

        // Calculate prorated credit
        $remaining = $subscription->ends_at->diffInDays(now());
        $oldPrice = $this->getPrice($subscription);

        $credit = (int) ($oldPrice * $remaining / ($oldCycle === 'monthly' ? 30 : 365));

        $subscription->update([
            'billing_cycle' => $newCycle,
            'price' => $this->getNewPrice($subscription, $newCycle),
            'ends_at' => $newCycle === 'monthly'
                ? now()->addMonth()
                : now()->addYear(),
        ]);

        // Apply credit
        if ($credit > 0) {
            CreditService::issue($subscription->user, $credit, 'Cycle switch credit');
        }

        event(new BillingCycleChanged($subscription, $oldCycle, $newCycle));
    }
}
```

## Plan Schema

### Plans Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `name` | `string` | |
| `slug` | `string` | Unique |
| `description` | `text?` | |
| `status` | `enum` | active / inactive / archived |
| `price_monthly` | `bigint` | In cents |
| `price_annual` | `bigint` | In cents |
| `currency` | `string` | ISO 4217 |
| `trial_days` | `int?` | |
| `features` | `json` | |
| `limits` | `json` | |
| `metadata` | `json` | |
| `is_active` | `bool` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Keep plan count simple** — 3-4 tiers is optimal
2. **Offer annual discounts** — 15-20% encourages commitment
3. **Include a free tier** — reduces barrier to entry
4. **Make trials frictionless** — no credit card if possible
5. **Send trial reminders** — convert more trials to paid
6. **Version plan features** — never remove from existing subscribers
7. **Test with Playwright** — verify plan selection and checkout flow
