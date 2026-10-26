# Grace Periods

## Overview

Grace periods provide a buffer between subscription expiry and service interruption. This document covers grace period configuration, payment retry logic, and service access during grace.

## Grace Period Configuration

```php
// config/grace-periods.php
return [
    'enabled' => true,

    'length_days' => 7,

    'access' => [
        'allow_during_grace' => true,
        'restrict_features' => false,
        'show_banner' => true,
    ],

    'payment_retry' => [
        'enabled' => true,
        'schedule' => [
            1 => 0,       // immediate
            2 => 86400,   // 1 day
            3 => 259200,  // 3 days
            4 => 604800,  // 7 days
        ],
    ],

    'notifications' => [
        'on_enter' => true,
        'daily_reminder' => true,
        'final_warning' => true,
        'final_warning_days' => 1,
    ],

    'expiration' => [
        'auto_expire' => true,
        'deactivate_after_grace' => true,
    ],
];
```

## Grace Period Lifecycle

```
┌──────────┐   fail    ┌──────────┐   retry    ┌──────────┐
│ Active   │ ────────► │ Grace    │ ─────────► │ Payment  │
│ Sub      │           │ Period   │            │ Retry    │
└──────────┘           └──────────┘            └──────────┘
                           │                       │
                      expires                success/fail
                           │                       │
                           ▼                       ▼
                     ┌──────────┐            ┌──────────┐
                     │ Expired  │            │ Active/  │
                     │          │            │ Expired  │
                     └──────────┘            └──────────┘
```

### Grace Period States

| State | Description | Access |
|-------|-------------|--------|
| `active` | Paid subscription | Full access |
| `grace_period` | Payment failed, in grace | Full or limited |
| `expired` | Grace period ended | No access |

## Entering Grace Period

```php
class GracePeriodService
{
    public function enterGracePeriod(Subscription $subscription): void
    {
        $graceLength = config('grace-periods.length_days');

        $subscription->update([
            'status' => 'grace_period',
            'grace_period_starts_at' => now(),
            'grace_period_ends_at' => now()->addDays($graceLength),
        ]);

        // Send notification
        if (config('grace-periods.notifications.on_enter')) {
            Notification::send(
                $subscription->user,
                new GracePeriodStartedNotification($subscription)
            );
        }

        event(new GracePeriodStarted($subscription));
    }

    public function isInGracePeriod(Subscription $subscription): bool
    {
        return $subscription->status === 'grace_period'
            && $subscription->grace_period_ends_at
            && $subscription->grace_period_ends_at->isFuture();
    }

    public function getDaysRemaining(Subscription $subscription): int
    {
        if (!$this->isInGracePeriod($subscription)) {
            return 0;
        }

        return max(0, now()->diffInDays($subscription->grace_period_ends_at, false));
    }
}
```

## Payment Retry

### Retry Logic

```php
class GracePeriodPaymentRetry
{
    public function processRetries(): void
    {
        $inGrace = Subscription::where('status', 'grace_period')
            ->with('user')
            ->get();

        foreach ($inGrace as $subscription) {
            $this->attemptRetry($subscription);
        }
    }

    protected function attemptRetry(Subscription $subscription): void
    {
        $schedule = config('grace-periods.payment_retry.schedule');
        $attempt = $subscription->metadata['retry_attempt'] ?? 0;

        if (!isset($schedule[$attempt + 1])) {
            return; // no more retries scheduled
        }

        $delay = $schedule[$attempt + 1];
        $lastAttempt = $subscription->metadata['last_retry_at'] ?? null;

        if ($lastAttempt && now()->diffInSeconds(Carbon::parse($lastAttempt)) < $delay) {
            return; // not time yet
        }

        try {
            PaymentService::charge(
                user: $subscription->user,
                amount: $subscription->price,
                description: "Grace period retry: {$subscription->plan->name}",
            );

            // Payment succeeded
            $subscription->update([
                'status' => 'active',
                'ends_at' => $this->calculateNewEnd($subscription),
                'grace_period_ends_at' => null,
            ]);

            Notification::send(
                $subscription->user,
                new PaymentSucceededNotification($subscription)
            );

            event(new SubscriptionRenewed($subscription));
        } catch (PaymentException $e) {
            // Record attempt
            $subscription->update([
                'metadata' => array_merge($subscription->metadata ?? [], [
                    'retry_attempt' => $attempt + 1,
                    'last_retry_at' => now(),
                    'last_error' => $e->getMessage(),
                ]),
            ]);

            // Notify if final attempt
            if ($attempt + 1 >= count($schedule)) {
                $this->sendFinalWarning($subscription);
            }
        }
    }
}
```

### Retry Schedule

| Attempt | Delay | Notification |
|---------|-------|--------------|
| 1 | Immediate | Payment failed |
| 2 | 1 day | Payment retry failed |
| 3 | 3 days | Payment retry failed |
| 4 | 7 days | Final warning |

## Service Access During Grace

### Access Control

```php
class GracePeriodAccessControl
{
    public function hasAccess(Subscription $subscription, string $feature = null): bool
    {
        if ($subscription->status === 'active') {
            return true;
        }

        if (!config('grace-periods.access.allow_during_grace')) {
            return false;
        }

        if ($subscription->status !== 'grace_period') {
            return false;
        }

        if (!config('grace-periods.access.restrict_features')) {
            return true; // full access during grace
        }

        // Restricted access — only basic features
        $allowedFeatures = ['read', 'export', 'billing'];
        return in_array($feature, $allowedFeatures);
    }

    public function getAccessBanner(Subscription $subscription): ?string
    {
        if (!$this->isInGracePeriod($subscription)) {
            return null;
        }

        $daysRemaining = GracePeriodService::getDaysRemaining($subscription);

        return "Your subscription payment failed. You have {$daysRemaining} day(s) "
            . "to update your payment method before service interruption.";
    }
}
```

### Banner Blade Component

```php
@if($graceBanner = GracePeriodAccessControl::getAccessBanner($user->subscription()))
<div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-yellow-400">...</svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-yellow-700">{{ $graceBanner }}</p>
            <div class="mt-2">
                <a href="{{ route('billing.payment-methods') }}"
                   class="text-sm font-medium text-yellow-800 underline">
                    Update Payment Method
                </a>
            </div>
        </div>
    </div>
</div>
@endif
```

## Expiration

### Expiration Process

```php
class GracePeriodExpiration
{
    public function processExpiredGracePeriods(): void
    {
        $expired = Subscription::where('status', 'grace_period')
            ->where('grace_period_ends_at', '<=', now())
            ->get();

        foreach ($expired as $subscription) {
            $this->expire($subscription);
        }
    }

    protected function expire(Subscription $subscription): void
    {
        $subscription->update([
            'status' => 'expired',
            'expired_at' => now(),
            'grace_period_ends_at' => null,
        ]);

        // Deactivate features
        if (config('grace-periods.expiration.deactivate_after_grace')) {
            FeatureRevocationService::revokeAll($subscription->user);
        }

        // Notify user
        Notification::send(
            $subscription->user,
            new SubscriptionExpiredNotification($subscription)
        );

        event(new SubscriptionExpired($subscription));
    }
}
```

## Schema

### Subscriptions Table (Grace Period Columns)

| Column | Type | Description |
|--------|------|-------------|
| `status` | `enum` | active / grace_period / expired |
| `grace_period_starts_at` | `timestamp?` | |
| `grace_period_ends_at` | `timestamp?` | |
| `metadata` | `json` | retry attempts, errors |

## Best Practices

1. **Default to 7 days** — enough time without being too generous
2. **Allow full access during grace** — maintain goodwill
3. **Send daily reminders** — help users resolve payment issues
4. **Retry payments automatically** — use exponential backoff
5. **Show clear banners** — users should know their subscription status
6. **Track grace period metrics** — conversion rate from grace to active
7. **Don't delete data immediately** — archive for potential recovery
