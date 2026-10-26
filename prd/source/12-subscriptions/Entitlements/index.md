# Entitlement System

## Overview

The entitlement system manages feature access, usage limits, and quota enforcement. Entitlements determine what users can do based on their subscription plan.

## Entitlement Model

```php
class Entitlement extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'feature', 'limit',
        'used', 'reset_cycle', 'metadata',
    ];

    protected $casts = [
        'limit' => 'integer',
        'used' => 'integer',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
```

## Feature Entitlements

### Entitlement Types

| Type | Description | Behavior |
|------|-------------|----------|
| `boolean` | On/off feature | Enabled or disabled |
| `limit` | Numeric limit | Track usage against limit |
| `unlimited` | No limit | Always available |

### Entitlement Configuration

```php
// config/entitlements.php
return [
    'features' => [
        'projects' => [
            'type' => 'limit',
            'label' => 'Projects',
            'reset_cycle' => 'monthly',
        ],
        'storage' => [
            'type' => 'limit',
            'label' => 'Storage (bytes)',
            'reset_cycle' => 'monthly',
        ],
        'api_calls' => [
            'type' => 'limit',
            'label' => 'API Calls',
            'reset_cycle' => 'monthly',
        ],
        'team_members' => [
            'type' => 'limit',
            'label' => 'Team Members',
            'reset_cycle' => null, // lifetime
        ],
        'custom_domain' => [
            'type' => 'boolean',
            'label' => 'Custom Domain',
        ],
        'sso' => [
            'type' => 'boolean',
            'label' => 'SSO Integration',
        ],
        'priority_support' => [
            'type' => 'boolean',
            'label' => 'Priority Support',
        ],
    ],
];
```

### Entitlement Resolution

```php
class EntitlementResolver
{
    public function resolve(User $user, string $feature): EntitlementResult
    {
        $subscription = $user->activeSubscription();

        if (!$subscription) {
            return new EntitlementResult(
                allowed: false,
                reason: 'No active subscription',
            );
        }

        $plan = $subscription->plan;
        $config = config("entitlements.features.{$feature}");

        if (!$config) {
            return new EntitlementResult(
                allowed: false,
                reason: 'Unknown feature',
            );
        }

        $entitlement = Entitlement::firstOrCreate(
            [
                'user_id' => $user->id,
                'feature' => $feature,
            ],
            [
                'plan_id' => $plan->id,
                'limit' => $this->getPlanLimit($plan, $feature),
                'used' => 0,
                'reset_cycle' => $config['reset_cycle'],
            ]
        );

        // Check if limit exceeded
        if ($config['type'] === 'limit' && $entitlement->limit !== -1) {
            if ($entitlement->used >= $entitlement->limit) {
                return new EntitlementResult(
                    allowed: false,
                    reason: "{$config['label']} limit reached",
                    limit: $entitlement->limit,
                    used: $entitlement->used,
                    remaining: 0,
                );
            }
        }

        return new EntitlementResult(
            allowed: true,
            limit: $entitlement->limit,
            used: $entitlement->used,
            remaining: $entitlement->limit === -1 ? null : $entitlement->limit - $entitlement->used,
        );
    }

    protected function getPlanLimit(SubscriptionPlan $plan, string $feature): int
    {
        return $plan->features[$feature]['limit'] ?? -1;
    }
}
```

## Usage Limits

### Usage Tracking

```php
class UsageTracker
{
    public function track(User $user, string $feature, int $amount = 1): void
    {
        $entitlement = Entitlement::where('user_id', $user->id)
            ->where('feature', $feature)
            ->first();

        if (!$entitlement) {
            return;
        }

        $entitlement->increment('used', $amount);

        // Check if approaching limit
        if ($entitlement->limit !== -1) {
            $percentage = ($entitlement->used / $entitlement->limit) * 100;

            if ($percentage >= 80) {
                event(new UsageLimitApproaching($user, $feature, $percentage));
            }

            if ($percentage >= 100) {
                event(new UsageLimitReached($user, $feature));
            }
        }

        // Invalidate cache
        Cache::forget("entitlement:{$user->id}:{$feature}");
    }

    public function reset(User $user, string $feature): void
    {
        Entitlement::where('user_id', $user->id)
            ->where('feature', $feature)
            ->update(['used' => 0]);
    }

    public function getUsage(User $user, string $feature): int
    {
        return Cache::remember(
            "entitlement:{$user->id}:{$feature}",
            now()->addMinutes(5),
            function () use ($user, $feature) {
                $entitlement = Entitlement::where('user_id', $user->id)
                    ->where('feature', $feature)
                    ->first();

                return $entitlement?->used ?? 0;
            }
        );
    }
}
```

### Usage Reset Schedule

```php
class UsageResetCommand extends Command
{
    protected $signature = 'entitlements:reset';

    public function handle(): int
    {
        $resettible = Entitlement::whereNotNull('reset_cycle')
            ->where(function ($q) {
                $q->where('reset_cycle', 'monthly')
                  ->where('last_reset_at', '<', now()->startOfMonth());
            })
            ->get();

        foreach ($resettible as $entitlement) {
            $entitlement->update([
                'used' => 0,
                'last_reset_at' => now(),
            ]);

            event(new EntitlementReset($entitlement));
        }

        $this->info("Reset {$resettible->count()} entitlements");

        return Command::SUCCESS;
    }
}
```

## Quota Management

### Quota Service

```php
class QuotaManager
{
    public function check(User $user, string $feature, int $requested = 1): QuotaCheck
    {
        $result = EntitlementResolver::resolve($user, $feature);

        if (!$result->allowed) {
            return new QuotaCheck(
                allowed: false,
                reason: $result->reason,
                upgradeRequired: true,
            );
        }

        if ($result->remaining !== null && $requested > $result->remaining) {
            return new QuotaCheck(
                allowed: false,
                reason: "Requested {$requested}, only {$result->remaining} remaining",
                upgradeRequired: $this->canUpgrade($user, $feature, $requested),
            );
        }

        return new QuotaCheck(allowed: true);
    }

    public function canUpgrade(User $user, string $feature, int $requested): bool
    {
        $currentPlan = $user->currentPlan();

        // Check if any higher plan has enough capacity
        $higherPlans = SubscriptionPlan::where('price_monthly', '>', $currentPlan->price_monthly)
            ->get();

        foreach ($higherPlans as $plan) {
            $limit = $plan->features[$feature]['limit'] ?? -1;
            if ($limit === -1 || $limit >= $requested) {
                return true;
            }
        }

        return false;
    }
}
```

### Quota Exceeded Handling

```php
class QuotaExceededHandler
{
    public function handle(User $user, string $feature): void
    {
        $config = config("entitlements.features.{$feature}");

        // Log the event
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => "quota.exceeded.{$feature}",
        ]);

        // Notify user
        Notification::send(
            $user,
            new QuotaExceededNotification($feature, $config['label'])
        );

        // Track for analytics
        AnalyticsEvent::create([
            'event' => 'quota.exceeded',
            'user_id' => $user->id,
            'data' => ['feature' => $feature],
        ]);
    }
}
```

## Entitlement Checks

### Blade Checks

```php
@entitle('projects')
    <button>Create Project</button>
@endentitle

@cannot('projects')
    <div class="upgrade-prompt">
        <p>You've reached your project limit.</p>
        <a href="/pricing">Upgrade your plan</a>
    </div>
@endcannot
```

### Livewire Checks

```php
class ProjectController extends Component
{
    public function create(): void
    {
        $check = QuotaManager::check($this->user, 'projects');

        if (!$check->allowed) {
            $this->dispatch('quota-exceeded', [
                'feature' => 'projects',
                'reason' => $check->reason,
            ]);
            return;
        }

        // proceed with creation
    }
}
```

## Schema

### Entitlements Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `user_id` | `bigint` | FK to users |
| `plan_id` | `bigint` | FK to plans |
| `feature` | `string` | Feature identifier |
| `limit` | `bigint` | Max allowed (-1 = unlimited) |
| `used` | `bigint` | Current usage |
| `reset_cycle` | `string?` | monthly / null |
| `last_reset_at` | `timestamp?` | |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Cache entitlement checks** — they're called frequently
2. **Reset usage on schedule** — monthly for most features
3. **Warn before limits** — proactive notifications reduce churn
4. **Track quota metrics** — understand usage patterns
5. **Offer upgrade paths** — when quota is exceeded
6. **Don't block silently** — always explain why an action is blocked
7. **Test with Playwright** — verify entitlement enforcement in UI
