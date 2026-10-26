# License Management

## Overview

License management handles license key generation, activation, deactivation, seat limits, and license tiers for software products.

## License Model

```php
class License extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'key', 'status',
        'tier', 'seats_limit', 'seats_used',
        'activated_at', 'expires_at', 'metadata',
    ];

    protected $casts = [
        'seats_limit' => 'int',
        'seats_used' => 'int',
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function activations(): HasMany
    {
        return $this->hasMany(LicenseActivation::class);
    }
}
```

## License Key Generation

### Key Format

```
XXXXX-XXXXX-XXXXX-XXXXX-XXXXX
```

| Segment | Length | Description |
|---------|--------|-------------|
| 1 | 5 | Product identifier |
| 2 | 5 | Random unique string |
| 3 | 5 | Random unique string |
| 4 | 5 | Checksum |
| 5 | 5 | Random unique string |

### Key Generator

```php
class LicenseKeyGenerator
{
    public function generate(Product $product): string
    {
        $prefix = strtoupper(substr($product->sku, 0, 5));
        $segments = [$prefix];

        for ($i = 0; $i < 3; $i++) {
            $segments[] = $this->randomSegment();
        }

        $checksum = $this->checksum(implode('-', $segments));
        $segments[] = $checksum;

        return implode('-', $segments);
    }

    protected function randomSegment(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $segment = '';
        for ($i = 0; $i < 5; $i++) {
            $segment .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $segment;
    }

    protected function checksum(string $key): string
    {
        $sum = 0;
        for ($i = 0; $i < strlen($key); $i++) {
            $sum += ord($key[$i]);
        }
        return strtoupper(dechex($sum % 32768));
    }
}
```

## Activation

### Activation Flow

```
POST /api/licenses/activate
{
    "key": "XXXXX-XXXXX-XXXXX-XXXXX-XXXXX",
    "instance": "machine-id-1234"
}

Response:
{
    "valid": true,
    "license": {
        "tier": "pro",
        "expires_at": "2025-12-31",
        "features": ["feature_a", "feature_b"]
    }
}
```

### Activation Service

```php
class LicenseActivationService
{
    public function activate(string $key, string $instanceId, ?User $user = null): LicenseActivation
    {
        $license = License::where('key', $key)->first();

        if (!$license || !$license->isValid()) {
            throw new InvalidLicenseException('Invalid or expired license key.');
        }

        if ($license->seats_limit && $license->seats_used >= $license->seats_limit) {
            throw new SeatLimitReachedException('License seat limit reached.');
        }

        $existing = $license->activations()
            ->where('instance_id', $instanceId)
            ->first();

        if ($existing) {
            $existing->update(['last_check_in' => now()]);
            return $existing;
        }

        $license->increment('seats_used');

        return $license->activations()->create([
            'instance_id' => $instanceId,
            'user_id' => $user?->id,
            'ip_address' => request()->ip(),
            'activated_at' => now(),
        ]);
    }

    public function deactivate(string $key, string $instanceId): void
    {
        $license = License::where('key', $key)->firstOrFail();

        $activation = $license->activations()
            ->where('instance_id', $instanceId)
            ->first();

        if ($activation) {
            $activation->delete();
            $license->decrement('seats_used');
        }
    }
}
```

## Deactivation

```php
class LicenseDeactivationController extends Controller
{
    public function deactivate(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'instance_id' => 'required|string',
        ]);

        LicenseActivationService::deactivate(
            $request->key,
            $request->instance_id
        );

        return response()->json(['deactivated' => true]);
    }
}
```

## Seat Limits

### Seat Management

```php
class SeatManager
{
    public function getAvailableSeats(License $license): ?int
    {
        if (!$license->seats_limit) {
            return null; // unlimited
        }

        return $license->seats_limit - $license->seats_used;
    }

    public function canActivate(License $license): bool
    {
        return $this->getAvailableSeats($license) > 0;
    }

    public function getActivations(License $license): Collection
    {
        return $license->activations()->get();
    }

    public function forceDeactivate(License $license, string $instanceId): void
    {
        $activation = $license->activations()
            ->where('instance_id', $instanceId)
            ->first();

        if ($activation) {
            $activation->delete();
            $license->decrement('seats_used');
        }
    }
}
```

### Seat Schema

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `license_id` | `bigint` | FK to licenses |
| `instance_id` | `string` | Unique machine identifier |
| `user_id` | `bigint?` | FK to users |
| `ip_address` | `string?` | |
| `activated_at` | `timestamp` | |
| `last_check_in` | `timestamp?` | |
| `created_at` | `timestamp` | |

## License Tiers

| Tier | Price | Seats | Features | Support |
|------|-------|-------|----------|---------|
| Starter | $29/yr | 1 | Core features | Community |
| Pro | $79/yr | 5 | All features | Email |
| Business | $199/yr | 25 | All + priority | Priority |
| Enterprise | Custom | Unlimited | All + SLA | Dedicated |

### Tier Validation

```php
class LicenseValidator
{
    public function validate(License $license): LicenseStatus
    {
        if ($license->status !== 'active') {
            return new LicenseStatus(valid: false, reason: 'License is inactive.');
        }

        if ($license->expires_at && $license->expires_at->isPast()) {
            return new LicenseStatus(valid: false, reason: 'License has expired.');
        }

        if ($license->seats_limit && $license->seats_used >= $license->seats_limit) {
            return new LicenseStatus(valid: false, reason: 'Seat limit reached.');
        }

        return new LicenseStatus(
            valid: true,
            tier: $license->tier,
            expiresAt: $license->expires_at,
            features: $this->resolveFeatures($license),
        );
    }

    protected function resolveFeatures(License $license): array
    {
        return config("licenses.tiers.{$license->tier}.features", []);
    }
}
```

## License Schema

### Licenses Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | `bigint` | Primary key |
| `user_id` | `bigint` | FK to users |
| `product_id` | `bigint` | FK to products |
| `key` | `string` | Unique license key |
| `status` | `enum` | active / inactive / expired / revoked |
| `tier` | `string` | License tier |
| `seats_limit` | `int?` | Max activations |
| `seats_used` | `int` | Current activations |
| `activated_at` | `timestamp?` | |
| `expires_at` | `timestamp?` | |
| `metadata` | `json` | |
| `created_at` | `timestamp` | |
| `updated_at` | `timestamp` | |

## Best Practices

1. **Generate unique keys** — use cryptographic randomness
2. **Validate server-side** — never trust client validation
3. **Track activations** — know where licenses are used
4. **Support deactivation** — allow users to move between machines
5. **Enforce seat limits** — prevent license abuse
6. **Send expiration reminders** — proactive renewal notices
7. **Log all activation attempts** — security audit trail
