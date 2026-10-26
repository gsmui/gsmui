# Renewal Process

## Overview

The renewal process handles automatic subscription renewals, renewal reminders, failed payment handling, and grace periods. This document covers the complete renewal lifecycle.

## Auto-Renewal

### Renewal Flow

```
┌──────────┐   due    ┌──────────┐   success   ┌──────────┐
│ Active   │ ───────► │ Renewal  │ ──────────► │ Active   │
│ Sub      │          │ Attempt  │             │ (renewed)│
└──────────┘          └──────────┘             └──────────┘
                           │
                      failure
                           │
                           ▼
                     ┌──────────┐   retry   ┌──────────┐
                     │ Failed   │ ────────► │ Retry    │
                     └──────────┘           └──────────┘
                           │
                      max retries
                           │
                           ▼
                     �┌──────────┐
                     │ Expired  │
                     └──────────┘
```

### Renewal Service

```php
class RenewalService
{
    public function processRenewal(Subscription $subscription): RenewalResult
    {
        try {
            $payment = PaymentService::charge(
                user: $subscription->user,
                amount: $subscription->price,
                description: "Renewal: {$subscription->plan->name}",
                metadata: ['subscription_id' => $subscription->id],
            );

            $this->completeRenewal($subscription, $payment);

            return new RenewalResult(success: true, transactionId: $payment->id);
        } catch (PaymentException $e) {
            $this->handleFailedRenewal($subscription, $e);

            return new RenewalResult(success: false, error: $e->getMessage());
        }
    }

    protected function completeRenewal(Subscription $subscription, $payment): void
    {
        $newEnd = match ($subscription->billing_cycle) {
            'monthly' => $subscription->ends_at->addMonth(),
            'annual' => $subscription->ends_at->addYear(),
        };

        $subscription->update([
            'status' => 'active',
            'ends_at' => $newEnd,
            'renewal_count' => $subscription->renewal_count + 1,
            'last_renewed_at' => now(),
        ]);

        event(new SubscriptionRenewed($subscription, $payment));
    }

    public function processDueRenewals(): void
    {
        $dueSubscriptions = Subscription::where('status', 'active')
            ->where('ends_at', '<=', now()->addDays(3))
            ->where('auto_renew', true)
            ->get();

        foreach ($dueSubscriptions as $subscription) {
            $this->processRenewal($subscription);
        }
    }
}
```

### Renewal Schedule

| Subscription | Renews On | Amount | Notification |
|--------------|-----------|--------|--------------|
| Monthly | Same day each month | $49.00 | 3 days before |
| Annual | Same date each year | $490.00 | 30 days before |
| Quarterly | Same day each quarter | $147.00 | 7 days before |

## Renewal Reminders

### Reminder Schedule

```php
'renewal_reminders' => [
    'enabled' => true,
    'schedule' => [
        'monthly' => [
            7 => 'renewal.7_days',
            3 => 'renewal.3_days',
            1 => 'renewal.1_day',
        ],
        'annual' => [
            30 => 'renewal.30_days',
            14 => 'renewal.14_days',
            7 => 'renewal.7_days',
            1 => 'renewal.1_day',
        ],
    ],
],
```

### Reminder Job

```php
class RenewalReminderCommand extends Command
{
    protected $signature = 'subscriptions:remind-renewal';

    public function handle(): int
    {
        $schedule = config('renewal_reminders.schedule');

        foreach ($schedule as $cycle => $days) {
            foreach ($days as $daysBefore => $template) {
                $subscriptions = Subscription::where('status', 'active')
                    ->where('billing_cycle', $cycle)
                    ->where('ends_at', now()->addDays($daysBefore))
                    ->where('auto_renew', true)
                    ->with('user', 'plan')
                    ->get();

                foreach ($subscriptions as $subscription) {
                    Mail::to($subscription->user)
                        ->send(new RenewalReminderMail($subscription, $template));
                }
            }
        }

        return Command::SUCCESS;
    }
}
```

### Reminder Email Template

```php
class RenewalReminderMail extends Mailable
{
    public function build(): Mailable
    {
        return $this->subject("Your {$this->subscription->plan->name} renews soon")
            ->view('emails.renewal.reminder', [
                'plan' => $this->subscription->plan,
                'amount' => money($this->subscription->price),
                'renewal_date' => $this->subscription->ends_at->format('M d, Y'),
                'payment_method' => $this->subscription->user->defaultPaymentMethod(),
            ]);
    }
}
```

## Failed Renewal Handling

### Retry Strategy

```php
'retry' => [
    'max_attempts' => 3,
    'schedule' => [
        1 => 0,       // immediate
        2 => 3600,    // 1 hour
        3 => 86400,   // 1 day
    ],
    'notify_on_each_retry' => true,
    'notify_admin_after' => 2,
],
```

### Failed Renewal Handler

```php
class FailedRenewalHandler
{
    public function handle(Subscription $subscription, Exception $exception): void
    {
        $attempt = $subscription->metadata['retry_count'] ?? 0;
        $maxAttempts = config('retry.max_attempts');

        $subscription->update([
            'metadata' => array_merge($subscription->metadata ?? [], [
                'retry_count' => $attempt + 1,
                'last_failure' => $exception->getMessage(),
                'last_failure_at' => now(),
            ]),
        ]);

        // Notify customer
        if (config('retry.notify_on_each_retry')) {
            Notification::send(
                $subscription->user,
                new RenewalFailedNotification($subscription, $exception)
            );
        }

        // Notify admin after multiple failures
        if ($attempt + 1 >= config('retry.notify_admin_after')) {
            Notification::send(
                User::role('admin')->get(),
                new AdminRenewalFailedNotification($subscription, $exception)
            );
        }

        // Schedule retry or expire
        if ($attempt + 1 < $maxAttempts) {
            $delay = config("retry.schedule." . ($attempt + 2));
            RenewalRetryJob::dispatch($subscription)
                ->delay(now()->addSeconds($delay));
        } else {
            $this->expireSubscription($subscription);
        }
    }

    protected function expireSubscription(Subscription $subscription): void
    {
        $subscription->update([
            'status' => 'expired',
            'expired_at' => now(),
        ]);

        event(new SubscriptionExpired($subscription));

        Notification::send(
            $subscription->user,
            new SubscriptionExpiredNotification($subscription)
        );
    }
}
```

## Grace Periods

### Grace Period Configuration

```php
'grace_period' => [
    'enabled' => true,
    'length_days' => 7,
    'allow_access' => true,
    'send_reminders' => true,
],
```

### Grace Period Service

```php
class GracePeriodService
{
    public function enterGracePeriod(Subscription $subscription): void
    {
        $graceLength = config('grace_period.length_days');

        $subscription->update([
            'status' => 'grace_period',
            'grace_period_ends_at' => now()->addDays($graceLength),
        ]);

        event(new GracePeriodStarted($subscription));
    }

    public function isInGracePeriod(Subscription $subscription): bool
    {
        return $subscription->status === 'grace_period'
            && $subscription->grace_period_ends_at
            && $subscription->grace_period_ends_at->isFuture();
    }

    public function hasAccess(Subscription $subscription): bool
    {
        if ($subscription->status === 'active') {
            return true;
        }

        if ($this->isInGracePeriod($subscription) && config('grace_period.allow_access')) {
            return true;
        }

        return false;
    }
}
```

## Schema

### Subscriptions Table (Renewal Columns)

| Column | Type | Description |
|--------|------|-------------|
| `auto_renew` | `bool` | Default: true |
| `billing_cycle` | `enum` | monthly / annual |
| `price` | `bigint` | Current price |
| `ends_at` | `timestamp` | Next renewal date |
| `renewal_count` | `int` | Total renewals completed |
| `last_renewed_at` | `timestamp?` | |
| `grace_period_ends_at` | `timestamp?` | |

## Best Practices

1. **Send renewal reminders** — prevent surprise charges
2. **Retry failed payments** — use exponential backoff
3. **Implement grace periods** — give users time to update payment
4. **Track renewal metrics** — churn rate, failure rate
5. **Allow auto-renew toggle** — let users opt out
6. **Test renewal flows** — use Stripe test mode
7. **Handle edge cases** — currency changes, plan changes during renewal
