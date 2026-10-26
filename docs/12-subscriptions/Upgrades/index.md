# Plan Upgrades

## Overview

Plan upgrades allow subscribers to move to a higher-tier plan. This document covers proration, immediate vs next-billing upgrades, and feature access transitions.

## Upgrade Flow

```
┌──────────┐   upgrade   ┌──────────┐   prorate   ┌──────────┐
│ Current  │ ──────────► │ Calculate│ ──────────► │ Charge   │
│ Plan     │             │ Credit   │             │ Diff     │
└──────────┘             └──────────┘             └──────────┘
                                                         │
                                                    activate
                                                         │
                                                         ▼
                                                   ┌──────────┐
                                                   │ New Plan │
                                                   │ Active   │
                                                   └──────────┘
```

## Proration

### Proration Calculation

```php
class ProrationCalculator
{
    public function calculate(Subscription $subscription, SubscriptionPlan $newPlan): ProrationResult
    {
        $currentPlan = $subscription->plan;
        $remaining = $subscription->ends_at->diffInDays(now());
        $totalDays = $subscription->billing_cycle === 'monthly' ? 30 : 365;

        // Calculate credit for unused time on current plan
        $currentPrice = match ($subscription->billing_cycle) {
            'monthly' => $currentPlan->price_monthly,
            'annual' => $currentPlan->price_annual,
        };

        $credit = (int) ($currentPrice * $remaining / $totalDays);

        // Calculate charge for new plan
        $newPrice = match ($subscription->billing_cycle) {
            'monthly' => $newPlan->price_monthly,
            'annual' => $newPlan->price_annual,
        };

        // Pro-rate new plan for remaining days
        $charge = (int) ($newPrice * $remaining / $totalDays);

        // Net amount
        $net = $charge - $credit;

        return new ProrationResult(
            credit: $credit,
            charge: $charge,
            net: max(0, $net),
            refund: $net < 0 ? abs($net) : 0,
        );
    }
}
```

### Proration Example

| Scenario | Current Plan | New Plan | Days Left | Credit | Charge | Net |
|----------|-------------|----------|-----------|--------|--------|-----|
| Upgrade mid-month | Pro ($49) | Business ($99) | 15 | $24.50 | $49.50 | $25.00 |
| Upgrade near end | Starter ($19) | Pro ($49) | 3 | $1.90 | $4.90 | $3.00 |
| Downgrade mid-month | Business ($99) | Pro ($49) | 15 | $49.50 | $24.50 | $0 (credit) |

## Immediate vs Next Billing

### Immediate Upgrade

```php
class ImmediateUpgradeService
{
    public function upgrade(Subscription $subscription, SubscriptionPlan $newPlan): UpgradeResult
    {
        $proration = ProrationCalculator::calculate($subscription, $newPlan);

        if ($proration->net > 0) {
            // Charge the difference
            PaymentService::charge(
                user: $subscription->user,
                amount: $proration->net,
                description: "Upgrade to {$newPlan->name}",
            );
        } elseif ($proration->refund > 0) {
            // Issue credit for downgrade
            CreditService::issue(
                user: $subscription->user,
                amount: $proration->refund,
                reason: 'Plan downgrade credit',
            );
        }

        $subscription->update([
            'plan_id' => $newPlan->id,
            'price' => $this->getPrice($newPlan, $subscription->billing_cycle),
            'status' => 'active',
        ]);

        event(new SubscriptionUpgraded($subscription, $newPlan, $proration));

        return new UpgradeResult(
            success: true,
            proration: $proration,
            newPlan: $newPlan,
        );
    }
}
```

### Next Billing Upgrade

```php
class NextBillingUpgradeService
{
    public function scheduleUpgrade(Subscription $subscription, SubscriptionPlan $newPlan): ScheduledUpgrade
    {
        $scheduled = ScheduledUpgrade::create([
            'subscription_id' => $subscription->id,
            'new_plan_id' => $newPlan->id,
            'scheduled_for' => $subscription->ends_at,
        ]);

        event(new UpgradeScheduled($scheduled));

        return $scheduled;
    }

    public function processScheduledUpgrades(): void
    {
        $due = ScheduledUpgrade::where('scheduled_for', '<=', now())
            ->with('subscription', 'newPlan')
            ->get();

        foreach ($due as $upgrade) {
            $subscription = $upgrade->subscription;

            $subscription->update([
                'plan_id' => $upgrade->new_plan_id,
                'price' => $this->getPrice($upgrade->newPlan, $subscription->billing_cycle),
            ]);

            $upgrade->update(['processed_at' => now()]);

            event(new ScheduledUpgradeProcessed($upgrade));
        }
    }
}
```

## Feature Access Transition

### Access During Upgrade

```php
class FeatureAccessTransition
{
    public function resolveAccess(Subscription $subscription, string $feature): bool
    {
        $plan = $subscription->plan;

        // Immediate upgrade: access new features now
        if ($subscription->metadata['pending_upgrade']) {
            $newPlan = SubscriptionPlan::find($subscription->metadata['pending_upgrade']);
            return PlanFeatureService::allows($newPlan, $feature)
                || PlanFeatureService::allows($plan, $feature);
        }

        // Normal check
        return PlanFeatureService::allows($subscription, $feature);
    }

    public function transitionFeatures(Subscription $subscription, SubscriptionPlan $oldPlan, SubscriptionPlan $newPlan): void
    {
        // Revoke removed features
        $removed = array_diff(
            array_keys($oldPlan->features),
            array_keys($newPlan->features)
        );

        foreach ($removed as $feature) {
            event(new FeatureRevoked($subscription, $feature));
        }

        // Grant new features
        $added = array_diff(
            array_keys($newPlan->features),
            array_keys($oldPlan->features)
        );

        foreach ($added as $feature) {
            event(new FeatureGranted($subscription, $feature));
        }
    }
}
```

### Feature Transition Events

| Event | Trigger | Action |
|-------|---------|--------|
| `FeatureGranted` | New plan has feature | Enable feature access |
| `FeatureRevoked` | Old plan had, new doesn't | Disable feature access |
| `LimitIncreased` | New plan has higher limit | Update usage limits |
| `LimitDecreased` | New plan has lower limit | Warn if over limit |

## Upgrade Validation

```php
class UpgradeValidator
{
    public function validate(Subscription $subscription, SubscriptionPlan $newPlan): array
    {
        $errors = [];

        if ($newPlan->id === $subscription->plan_id) {
            $errors[] = 'You are already on this plan.';
        }

        if ($newPlan->price_monthly < $subscription->plan->price_monthly
            && $subscription->status === 'trialing') {
            $errors[] = 'Cannot downgrade during trial. Wait for trial to end.';
        }

        if ($subscription->status === 'cancelled') {
            $errors[] = 'Cannot upgrade a cancelled subscription. Please resubscribe.';
        }

        return $errors;
    }
}
```

## Schema

### Scheduled Upgrades Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `subscription_id` | `bigint` | FK to subscriptions |
| `new_plan_id` | `bigint` | FK to plans |
| `scheduled_for` | `timestamp` | |
| `processed_at` | `timestamp?` | |
| `created_at` | `timestamp` | |

## Best Practices

1. **Show proration preview** — users should know the cost before confirming
2. **Immediate access** — upgrade features instantly on payment
3. **Handle downgrades gracefully** — credit, don't charge
4. **Schedule upgrades** — option for next billing cycle
5. **Track upgrade metrics** — upgrade rate, average revenue per upgrade
6. **Test upgrade flows** — verify proration calculations
