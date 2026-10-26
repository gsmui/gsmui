# Plan Downgrades

## Overview

Plan downgrades allow subscribers to move to a lower-tier plan. This document covers downgrade restrictions, data retention, and feature access revocation.

## Downgrade Flow

```
┌──────────┐   downgrade   ┌──────────┐   validate   ┌──────────┐
│ Current  │ ────────────► │ Check    │ ────────────► │ Schedule │
│ Plan     │               │ Limits   │               │ Change   │
└──────────┘               └──────────┘               └──────────┘
                                                          │
                                                     next billing
                                                          │
                                                          ▼
                                                    ┌──────────┐
                                                    │ New Plan │
                                                    │ Active   │
                                                    └──────────┘
```

## Downgrade Rules

### Restriction Types

| Restriction | Description | Handling |
|-------------|-------------|----------|
| `data_overage` | User exceeds new plan limits | Warn, allow with grace |
| `feature_removal` | New plan lacks features | Revoke on downgrade date |
| `seat_reduction` | Fewer team seats | Deactivate excess members |
| `storage_reduction` | Less storage | Warn, block uploads |
| `active_trial` | Cannot downgrade during trial | Block until trial ends |

### Downgrade Validation

```php
class DowngradeValidator
{
    public function validate(Subscription $subscription, SubscriptionPlan $newPlan): array
    {
        $errors = [];
        $warnings = [];

        // Cannot downgrade to same or higher plan
        if ($newPlan->price_monthly >= $subscription->plan->price_monthly) {
            $errors[] = 'Selected plan is not a downgrade.';
        }

        // Cannot downgrade during trial
        if ($subscription->status === 'trialing') {
            $errors[] = 'Cannot downgrade during trial period.';
        }

        // Check data overages
        $overages = $this->checkOverages($subscription, $newPlan);
        if ($overages->isNotEmpty()) {
            $warnings = $overages->toArray();
        }

        // Check seat count
        $currentSeats = $subscription->team_members_count ?? 1;
        $newLimit = $newPlan->features['team_members']['limit'] ?? 1;
        if ($currentSeats > $newLimit) {
            $warnings[] = "You have {$currentSeats} team members but the new plan allows {$newLimit}.";
        }

        return ['errors' => $errors, 'warnings' => $warnings];
    }

    protected function checkOverages(Subscription $subscription, SubscriptionPlan $newPlan): Collection
    {
        $overages = collect();

        foreach ($newPlan->features as $feature => $config) {
            if (!isset($config['limit'])) {
                continue;
            }

            $usage = PlanFeatureService::getUsage($subscription, $feature);
            if ($usage > $config['limit']) {
                $overages->push("{$config['label']}: using {$usage}, limit will be {$config['limit']}");
            }
        }

        return $overages;
    }
}
```

## Downgrade Processing

### Scheduled Downgrade

```php
class DowngradeService
{
    public function scheduleDowngrade(Subscription $subscription, SubscriptionPlan $newPlan): ScheduledDowngrade
    {
        $this->validate($subscription, $newPlan);

        $downgrade = ScheduledDowngrade::create([
            'subscription_id' => $subscription->id,
            'new_plan_id' => $newPlan->id,
            'scheduled_for' => $subscription->ends_at,
        ]);

        // Notify user
        Notification::send(
            $subscription->user,
            new DowngradeScheduledNotification($subscription, $newPlan)
        );

        event(new DowngradeScheduled($downgrade));

        return $downgrade;
    }

    public function processDowngrade(ScheduledDowngrade $downgrade): void
    {
        $subscription = $downgrade->subscription;
        $oldPlan = $subscription->plan;
        $newPlan = $downgrade->newPlan;

        // Update subscription
        $subscription->update([
            'plan_id' => $newPlan->id,
            'price' => $this->getPrice($newPlan, $subscription->billing_cycle),
        ]);

        // Revoke removed features
        FeatureAccessTransition::transitionFeatures($subscription, $oldPlan, $newPlan);

        // Handle seat overages
        $this->handleSeatOverage($subscription, $newPlan);

        // Handle storage overage
        $this->handleStorageOverage($subscription, $newPlan);

        $downgrade->update(['processed_at' => now()]);

        event(new DowngradeProcessed($downgrade));
    }
}
```

## Data Retention

### Retention Policy

```php
'downgrade' => [
    'data_retention_days' => 30,
    'grace_period_days' => 7,
    'warn_before_days' => 7,
    'auto_delete_data' => false,
],
```

### Data Handling

```php
class DowngradeDataHandler
{
    public function handleDataRetention(Subscription $subscription, SubscriptionPlan $oldPlan, SubscriptionPlan $newPlan): void
    {
        // Identify data that exceeds new limits
        $excessData = $this->identifyExcessData($subscription, $oldPlan, $newPlan);

        foreach ($excessData as $item) {
            // Archive excess data
            DataArchive::create([
                'user_id' => $subscription->user_id,
                'type' => $item['type'],
                'data' => $item['data'],
                'retention_days' => config('downgrade.data_retention_days'),
                'expires_at' => now()->addDays(config('downgrade.data_retention_days')),
            ]);
        }

        // Notify user about data retention
        Notification::send(
            $subscription->user,
            new DataRetentionNotification($excessData)
        );
    }

    protected function identifyExcessData(Subscription $subscription, SubscriptionPlan $oldPlan, SubscriptionPlan $newPlan): array
    {
        $excess = [];

        // Check projects
        $projectLimit = $newPlan->features['projects']['limit'] ?? -1;
        if ($projectLimit !== -1) {
            $currentProjects = Project::where('user_id', $subscription->user_id)->count();
            if ($currentProjects > $projectLimit) {
                $excess[] = [
                    'type' => 'projects',
                    'count' => $currentProjects - $projectLimit,
                    'limit' => $projectLimit,
                ];
            }
        }

        // Check storage
        $storageLimit = $newPlan->features['storage']['limit'] ?? -1;
        if ($storageLimit !== -1) {
            $currentStorage = StorageUsage::get($subscription->user_id);
            if ($currentStorage > $storageLimit) {
                $excess[] = [
                    'type' => 'storage',
                    'current' => $currentStorage,
                    'limit' => $storageLimit,
                ];
            }
        }

        return $excess;
    }
}
```

## Feature Access Revocation

### Revocation Process

```php
class FeatureRevocationService
{
    public function revokeFeatures(Subscription $subscription, array $features): void
    {
        foreach ($features as $feature) {
            // Disable feature
            UserFeature::where('user_id', $subscription->user_id)
                ->where('feature', $feature)
                ->update(['is_active' => false]);

            // Notify user
            Notification::send(
                $subscription->user,
                new FeatureRevokedNotification($feature)
            );

            event(new FeatureRevoked($subscription, $feature));
        }
    }

    public function handleDowngradeRevocation(Subscription $subscription, SubscriptionPlan $oldPlan, SubscriptionPlan $newPlan): void
    {
        $oldFeatures = array_keys($oldPlan->features);
        $newFeatures = array_keys($newPlan->features);

        $removedFeatures = array_diff($oldFeatures, $newFeatures);

        $this->revokeFeatures($subscription, $removedFeatures);

        // Handle features with reduced limits
        foreach ($newPlan->features as $feature => $config) {
            if (!isset($config['limit'])) {
                continue;
            }

            $oldLimit = $oldPlan->features[$feature]['limit'] ?? -1;
            $newLimit = $config['limit'];

            if ($oldLimit !== -1 && $newLimit < $oldLimit) {
                $this->reduceFeatureLimit($subscription, $feature, $newLimit);
            }
        }
    }
}
```

## Schema

### Scheduled Downgrades Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `subscription_id` | `bigint` | FK to subscriptions |
| `new_plan_id` | `bigint` | FK to plans |
| `scheduled_for` | `timestamp` | |
| `processed_at` | `timestamp?` | |
| `created_at` | `timestamp` | |

### Data Archives Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `user_id` | `bigint` | FK to users |
| `type` | `string` | projects, storage, etc. |
| `data` | `json` | Archived data |
| `retention_days` | `int` | |
| `expires_at` | `timestamp` | |
| `created_at` | `timestamp` | |

## Best Practices

1. **Schedule downgrades** — don't apply immediately, give time to adjust
2. **Show data impact** — warn users about what they'll lose
3. **Archive, don't delete** — preserve data for a grace period
4. **Send reminders** — notify before downgrade takes effect
5. **Allow undo** — let users cancel scheduled downgrades
6. **Track churn reasons** — understand why users downgrade
7. **Offer alternatives** — suggest middle-tier plans before downgrade
