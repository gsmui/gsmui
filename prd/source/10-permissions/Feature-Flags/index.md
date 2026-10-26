# Feature Flags

## Overview

Feature flags enable controlled rollout of features without code deployments. Use them for gradual rollouts, A/B testing, kill switches, and user segmentation. This system integrates with gsmui's permission layer for authorization-aware feature gating.

## Boolean Flags

### Basic Usage

```php
use App\FeatureFlags;

// Check if a feature is enabled
if (FeatureFlags::isEnabled('new-dashboard')) {
    // show new dashboard
}

// In Blade
@if(FeatureFlags::isEnabled('new-checkout'))
    <x-new-checkout />
@else
    <x-old-checkout />
@endif

// In Livewire
public function mount(): void
{
    $this->showNewFeature = FeatureFlags::isEnabled('beta-editor');
}
```

### Defining Flags

```php
// config/feature-flags.php
return [
    'flags' => [
        'new-dashboard' => [
            'description' => 'Redesigned dashboard layout',
            'enabled' => true,
            'default' => false,
        ],
        'beta-editor' => [
            'description' => 'Rich text editor v2',
            'enabled' => false,
            'default' => false,
        ],
        'api-v2' => [
            'description' => 'Version 2 API endpoints',
            'enabled' => true,
            'default' => true,
        ],
    ],
];
```

## Percentage Rollouts

### Gradual Rollout

```php
// 10% of users see the feature
FeatureFlags::isEnabled('new-search', percentage: 10);

// Deterministic — same user always gets same result
FeatureFlags::isEnabled('new-search', percentage: 10, userId: $user->id);
```

### Rollout Configuration

```php
'flags' => [
    'new-pricing' => [
        'description' => 'Updated pricing page',
        'rollout' => [
            'enabled' => true,
            'percentage' => 25,
            'started_at' => '2024-01-15',
            'target_percentage' => 100,
            'increment' => 10,
            'increment_interval_days' => 7,
        ],
    ],
],
```

### Rollout Manager

```php
class RolloutManager
{
    public function increment(string $flag): void
    {
        $config = config("feature-flags.flags.{$flag}.rollout");

        if (!$config || !$config['enabled']) {
            return;
        }

        $current = $config['percentage'];
        $target = $config['target_percentage'];
        $increment = $config['increment'];

        $newPercentage = min($current + $increment, $target);

        config(["feature-flags.flags.{$flag}.rollout.percentage" => $newPercentage]);

        if ($newPercentage >= $target) {
            $this->completeRollout($flag);
        }
    }

    protected function completeRollout(string $flag): void
    {
        config(["feature-flags.flags.{$flag}.enabled" => true]);
        config(["feature-flags.flags.{$flag}.rollout.enabled" => false]);

        event(new RolloutCompleted($flag));
    }
}
```

## User Segments

### Segment Definitions

```php
'flags' => [
    'enterprise-features' => [
        'description' => 'Enterprise-only features',
        'segments' => [
            'type' => 'role',
            'values' => ['admin', 'super_admin'],
        ],
    ],
    'beta-testers' => [
        'description' => 'Features for beta testers',
        'segments' => [
            'type' => 'custom',
            'attribute' => 'is_beta_tester',
            'operator' => '=',
            'value' => true,
        ],
    ],
],
```

### Segment Types

| Type | Description | Example |
|------|-------------|---------|
| `role` | User role-based | Admins only |
| `attribute` | User attribute match | `is_beta_tester = true` |
| `organization` | Organization membership | Specific orgs |
| `plan` | Subscription plan tier | Pro users |
| `custom` | Custom callback | Complex logic |

### Segment Evaluation

```php
class SegmentEvaluator
{
    public function matches(User $user, array $segment): bool
    {
        return match ($segment['type']) {
            'role' => $user->hasAnyRole($segment['values']),
            'attribute' => $this->matchAttribute($user, $segment),
            'organization' => $user->organization_id === $segment['value'],
            'plan' => $user->subscription?->plan === $segment['value'],
            'custom' => $this->evaluateCustom($user, $segment),
            default => false,
        };
    }

    protected function matchAttribute(User $user, array $segment): bool
    {
        $value = $user->{$segment['attribute']};

        return match ($segment['operator']) {
            '=' => $value == $segment['value'],
            '!=' => $value != $segment['value'],
            '>' => $value > $segment['value'],
            '<' => $value < $segment['value'],
            'in' => in_array($value, $segment['value']),
            default => false,
        };
    }
}
```

## A/B Testing

### Defining Tests

```php
'flags' => [
    'checkout-layout' => [
        'description' => 'Checkout page layout test',
        'ab_test' => [
            'enabled' => true,
            'variants' => [
                'control' => [
                    'weight' => 50,
                    'config' => ['layout' => 'single-page'],
                ],
                'variant-a' => [
                    'weight' => 25,
                    'config' => ['layout' => 'multi-step'],
                ],
                'variant-b' => [
                    'weight' => 25,
                    'config' => ['layout' => 'sidebar'],
                ],
            ],
        ],
    ],
],
```

### Variant Assignment

```php
class AbTestService
{
    public function assignVariant(string $flag, User $user): string
    {
        $config = config("feature-flags.flags.{$flag}.ab_test");

        if (!$config['enabled']) {
            return 'control';
        }

        // Deterministic assignment based on user ID
        $hash = hash('xxh3', "{$flag}:{$user->id}");
        $bucket = hexdec(substr($hash, 0, 8)) % 100;

        $cumulative = 0;
        foreach ($config['variants'] as $name => $variant) {
            $cumulative += $variant['weight'];
            if ($bucket < $cumulative) {
                $this->trackAssignment($flag, $user, $name);
                return $name;
            }
        }

        return 'control';
    }

    public function getVariantConfig(string $flag, User $user): array
    {
        $variant = $this->assignVariant($flag, $user);
        return config("feature-flags.flags.{$flag}.ab_test.variants.{$variant}.config");
    }
}
```

### Tracking Results

```php
class AbTestResult extends Model
{
    protected $fillable = [
        'flag', 'user_id', 'variant', 'event', 'value',
    ];

    public function trackConversion(string $flag, User $user, string $event, float $value = 1): void
    {
        $variant = AbTestService::getVariant($flag, $user);

        $this->create([
            'flag' => $flag,
            'user_id' => $user->id,
            'variant' => $variant,
            'event' => $event,
            'value' => $value,
        ]);
    }
}
```

## Kill Switches

### Emergency Disable

```php
class KillSwitchController extends Controller
{
    public function toggle(Request $request, string $flag)
    {
        $this->authorize('manage-feature-flags');

        FeatureFlags::disable($flag);

        event(new KillSwitchActivated($flag, $this->user()));

        return redirect()->back()->with('success', "Feature '{$flag}' disabled.");
    }
}
```

### Kill Switch Configuration

```php
'flags' => [
    'payment-processing' => [
        'description' => 'Stripe payment integration',
        'kill_switch' => [
            'enabled' => true,
            'auto_disable_on_error' => true,
            'error_threshold' => 10,
            'error_window_minutes' => 5,
        ],
    ],
],
```

### Auto-Disable on Errors

```php
class FeatureFlagMonitor
{
    public function checkErrorRate(string $flag): void
    {
        $config = config("feature-flags.flags.{$flag}.kill_switch");

        if (!$config['auto_disable_on_error']) {
            return;
        }

        $errors = Cache::get("feature-flags:{$flag}:errors", 0);

        if ($errors >= $config['error_threshold']) {
            FeatureFlags::disable($flag);
            event(new KillSwitchAutoActivated($flag, $errors));
        }
    }

    public function recordError(string $flag): void
    {
        $window = config("feature-flags.flags.{$flag}.kill_switch.error_window_minutes");

        Cache::increment("feature-flags:{$flag}:errors");
        Cache::put(
            "feature-flags:{$flag}:errors:ttl",
            now()->addMinutes($window)
        );
    }
}
```

## API Reference

```php
// Check if enabled
FeatureFlags::isEnabled(string $flag, ?User $user = null): bool;

// Get variant for A/B test
FeatureFlags::getVariant(string $flag, User $user): string;

// Get variant config
FeatureFlags::getVariantConfig(string $flag, User $user): array;

// Enable/disable
FeatureFlags::enable(string $flag): void;
FeatureFlags::disable(string $flag): void;

// List all flags
FeatureFlags::all(): array;

// List active flags
FeatureFlags::active(): array;
```

## Best Practices

1. **Always have a kill switch** — be able to disable any feature instantly
2. **Use deterministic assignment** — same user always gets same variant
3. **Track meaningful metrics** — conversion, engagement, errors
4. **Set rollout end dates** — prevent permanent half-rollouts
5. **Clean up completed flags** — remove dead code after full rollout
6. **Limit flag count** — too many flags create cognitive overhead
