# Trial Management

## Overview

Trial management handles trial periods, extensions, conversion tracking, and trial restrictions. Trials let users experience your product before committing to a paid plan.

## Trial Configuration

```php
// config/trials.php
return [
    'enabled' => true,

    'defaults' => [
        'length_days' => 14,
        'require_credit_card' => false,
        'auto_convert' => false,
    ],

    'limits' => [
        'max_extensions' => 1,
        'extension_days' => 7,
        'max_trials_per_user' => 1,
    ],

    'restrictions' => [
        'enforce_limits' => true,
        'show_upgrade_prompt' => true,
    ],

    'reminders' => [
        'enabled' => true,
        'days_before' => [3, 1],
        'send_on_start' => true,
    ],

    'conversion' => [
        'track_trial_start' => true,
        'track_trial_end' => true,
        'track_conversion' => true,
    ],
];
```

## Trial Lifecycle

```
┌──────────┐   start    ┌──────────┐   extend   ┌──────────┐
│ No Trial │ ─────────► │ Trialing │ ─────────► │ Trialing │
└──────────┘            └──────────┘            └──────────┘
                              │
                         expires
                              │
                              ▼
                        ┌──────────┐   convert   ┌──────────┐
                        │ Expired  │ ──────────► │ Active   │
                        └──────────┘              └──────────┘
                              │
                         cancel
                              │
                              ▼
                        ┌──────────┐
                        │ Cancelled│
                        └──────────┘
```

### Trial States

| State | Description | Actions Available |
|-------|-------------|-------------------|
| `trialing` | Active trial period | Use all features |
| `trial_extended` | Trial extended | Use all features |
| `trial_expired` | Trial ended, not converted | Upgrade prompt |
| `converting` | Payment processing | Wait for confirmation |
| `active` | Converted to paid | Full access |

## Trial Extensions

### Extension Service

```php
class TrialExtensionService
{
    public function extend(Subscription $subscription, ?int $days = null): TrialExtension
    {
        $days = $days ?? config('trials.defaults.extension_days');

        $this->validateExtension($subscription);

        $extension = TrialExtension::create([
            'subscription_id' => $subscription->id,
            'days_added' => $days,
            'reason' => 'user_request',
        ]);

        $subscription->update([
            'trial_ends_at' => $subscription->trial_ends_at->addDays($days),
            'extensions_count' => $subscription->extensions_count + 1,
        ]);

        event(new TrialExtended($subscription, $days));

        return $extension;
    }

    public function extendByAdmin(Subscription $subscription, int $days, string $reason): TrialExtension
    {
        $extension = TrialExtension::create([
            'subscription_id' => $subscription->id,
            'days_added' => $days,
            'reason' => $reason,
            'extended_by' => auth()->id(),
        ]);

        $subscription->update([
            'trial_ends_at' => $subscription->trial_ends_at->addDays($days),
            'extensions_count' => $subscription->extensions_count + 1,
        ]);

        event(new TrialExtendedByAdmin($subscription, $days, $reason));

        return $extension;
    }

    protected function validateExtension(Subscription $subscription): void
    {
        $maxExtensions = config('trials.limits.max_extensions');

        if ($subscription->extensions_count >= $maxExtensions) {
            throw new MaxExtensionsReachedException(
                "Trial can only be extended {$maxExtensions} time(s)."
            );
        }

        if ($subscription->status !== 'trialing') {
            throw new InvalidTrialStateException('Only active trials can be extended.');
        }
    }
}
```

### Extension Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `subscription_id` | `bigint` | FK to subscriptions |
| `days_added` | `int` | |
| `reason` | `string` | user_request / admin / system |
| `extended_by` | `bigint?` | FK to users (admin) |
| `created_at` | `timestamp` | |

## Trial Conversion

### Conversion Tracking

```php
class TrialConversionTracker
{
    public function trackConversion(Subscription $subscription): void
    {
        $trialDuration = $subscription->trial_started_at->diffInDays(now());
        $plan = $subscription->plan;

        ConversionEvent::create([
            'user_id' => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'plan_id' => $plan->id,
            'trial_days' => $trialDuration,
            'converted_at' => now(),
            'revenue' => $plan->price_monthly,
        ]);

        event(new TrialConverted($subscription));
    }

    public function conversionRate(SubscriptionPlan $plan, int $days = 30): float
    {
        $trials = Subscription::where('plan_id', $plan->id)
            ->where('trial_started_at', '>=', now()->subDays($days))
            ->count();

        $converted = Subscription::where('plan_id', $plan->id)
            ->where('status', 'active')
            ->where('trial_started_at', '>=', now()->subDays($days))
            ->count();

        return $trials > 0 ? ($converted / $trials) * 100 : 0;
    }
}
```

### Conversion Optimization

```php
class TrialOptimizer
{
    public function getInsights(User $user): array
    {
        $subscription = $user->activeSubscription();

        if (!$subscription || $subscription->status !== 'trialing') {
            return [];
        }

        $daysRemaining = now()->diffInDays($subscription->trial_ends_at, false);
        $usage = $this->getUsageSummary($subscription);

        return [
            'days_remaining' => $daysRemaining,
            'features_used' => $usage['features_used'],
            'features_unused' => $usage['features_unused'],
            'usage_percentage' => $usage['percentage'],
            'recommended_plan' => $this->recommendPlan($usage),
        ];
    }
}
```

## Trial Restrictions

### Restriction Rules

```php
class TrialRestrictionService
{
    public function getRestrictions(Subscription $subscription): array
    {
        if ($subscription->status !== 'trialing') {
            return [];
        }

        $restrictions = [];

        $plan = $subscription->plan;
        $features = $plan->features ?? [];

        foreach ($features as $feature => $config) {
            if (isset($config['trial_limit'])) {
                $usage = PlanFeatureService::getUsage($subscription, $feature);

                if ($usage >= $config['trial_limit']) {
                    $restrictions[] = [
                        'feature' => $feature,
                        'limit' => $config['trial_limit'],
                        'current' => $usage,
                        'message' => "Trial limit reached for {$config['label']}",
                    ];
                }
            }
        }

        return $restrictions;
    }

    public function isRestricted(Subscription $subscription, string $feature): bool
    {
        return count(array_filter(
            $this->getRestrictions($subscription),
            fn ($r) => $r['feature'] === $feature
        )) > 0;
    }
}
```

### Trial Upgrade Prompt

```php
// resources/views/subscription/trial-upgrade.blade.php
@if($subscription->status === 'trialing')
<div class="trial-banner">
    <p>
        Your trial ends in {{ $subscription->trial_ends_at->diffForHumans() }}.
        <a href="/pricing">Upgrade now</a> to continue using all features.
    </p>
</div>

@if($restrictions->count() > 0)
<div class="trial-restrictions">
    <h4>Trial Limits Reached</h4>
    <ul>
        @foreach($restrictions as $restriction)
        <li>{{ $restriction['message'] }}</li>
        @endforeach
    </ul>
    <a href="/pricing">Upgrade to remove limits</a>
</div>
@endif
@endif
```

## Trial Schema

### Subscriptions Table (Trial Columns)

| Column | Type | Description |
|--------|------|-------------|
| `status` | `enum` | trialing / active / cancelled / expired |
| `trial_started_at` | `timestamp?` | |
| `trial_ends_at` | `timestamp?` | |
| `extensions_count` | `int` | Default: 0 |

## Best Practices

1. **Keep trials short** — 14 days is optimal for most products
2. **Don't require credit card** — reduces friction
3. **Send reminders** — at 3 days and 1 day before expiry
4. **Track conversion metrics** — know which plans convert best
5. **Show usage progress** — demonstrate value during trial
6. **Allow extensions** — one extension for interested users
7. **Restrict, don't block** — let users see what they're missing
