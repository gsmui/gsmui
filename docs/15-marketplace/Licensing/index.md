---
title: Marketplace Licenses
description: License types, activation, usage tracking, DRM, and compliance.
order: 15.10
group: Licensing
---

# Marketplace Licenses

The GsmUi Marketplace license system manages product licensing, activation, usage tracking, and compliance.

## License Features

| Feature | Description |
|---|---|
| License types | Multiple licensing models |
| Activation | License key activation |
| Usage tracking | Project usage monitoring |
| DRM | Digital rights management |
| Compliance | License compliance checks |

## License Types

### License Models

| Type | Description | Price Multiplier |
|---|---|---|
| Single Site | 1 project license | 1× |
| Multi Site | Up to 5 projects | 2× |
| Unlimited | Unlimited projects | 3× |
| Enterprise | Custom terms | Custom |
| OEM | Redistribution rights | Custom |

### License Comparison

| Feature | Single | Multi | Unlimited | Enterprise |
|---|---|---|---|---|
| Projects | 1 | 5 | Unlimited | Unlimited |
| Domains | 1 | 5 | Unlimited | Unlimited |
| Updates | 1 year | 1 year | 1 year | Lifetime |
| Support | 6 months | 1 year | 1 year | Lifetime |
| Source access | Yes | Yes | Yes | Yes |
| White-label | No | No | No | Yes |

## License Keys

### Key Format

```
GSMUI-XXXX-XXXX-XXXX-XXXX
```

### Key Schema

| Field | Description |
|---|---|
| `key` | License key string |
| `product` | Associated product |
| `type` | License type |
| `status` | Active, expired, revoked |
| `activations` | Usage count |
| `max_activations` | Activation limit |
| `expires_at` | Expiration date |

### License Display

```blade
<x-gsmui:license-card
    :license="$license"
    :product="$product"
/>
```

### License Output

```
┌─────────────────────────────────────────────┐
│ 🔑 License Key                              │
├─────────────────────────────────────────────┤
│ GSMUI-ABCD-EFGH-IJKL-MNOP                  │
│                                             │
│ Product: Button Pro                         │
│ Type: Multi Site (5 projects)               │
│ Status: ✅ Active                           │
│ Activations: 3/5                            │
│ Expires: Dec 31, 2024                       │
│                                             │
│ [Manage Activations]  [View History]        │
└─────────────────────────────────────────────┘
```

## Activation

### Activation Process

```
Enter license key
    ↓
Validate key
    ↓
Check activation limit
    ↓
Register project
    ↓
Activate product
    ↓
Return license info
```

### Activation UI

```blade
<x-gsmui:license-activate
    wire:model="showActivate"
    :product="$product"
>
    <gsmui:form-field
        name="license_key"
        label="License Key"
        placeholder="GSMUI-XXXX-XXXX-XXXX-XXXX"
        required
    />

    <gsmui:form-field
        name="project_name"
        label="Project Name"
        placeholder="My Awesome Project"
        required
    />
</x-gsmui:license-activate>
```

### Activation Limits

| License Type | Max Activations | Projects |
|---|---|---|
| Single Site | 1 | 1 |
| Multi Site | 5 | 5 |
| Unlimited | Unlimited | Unlimited |

### Activation Management

| Action | Description |
|---|---|
| Activate | Register new project |
| Deactivate | Remove project |
| Rename | Update project name |
| View | See all activations |

## Usage Tracking

### Usage Dashboard

```blade
<x-gsmui:license-usage
    :license="$license"
    :activations="$activations"
/>
```

### Usage Display

```
┌─────────────────────────────────────────────┐
│ 📊 License Usage                            │
├─────────────────────────────────────────────┤
│ Activations: 3/5                            │
│                                             │
│ 1. my-app.com        ✅ Active  Mar 1      │
│ 2. client-app.com    ✅ Active  Mar 15     │
│ 3. staging-app.com   ✅ Active  Apr 1      │
│                                             │
│ 2 remaining activations                     │
└─────────────────────────────────────────────┘
```

### Usage Metrics

| Metric | Description |
|---|---|
| Active activations | Current usage |
| Total activations | Historical count |
| Last check-in | Last validation |
| Usage history | Activation log |

## DRM Protection

### DRM Features

| Feature | Description |
|---|---|
| Key validation | Server-side validation |
| Fallback mode | Offline validation |
| Tamper detection | Code integrity checks |
| Expiration checks | Time-based expiration |

### Validation Flow

```php
// Client-side validation
$valid = GsmuiLicense::validate($licenseKey, $productId);

if (!$valid) {
    // Show activation required
    return redirect()->route('license.activate');
}
```

### Fallback Mode

| Scenario | Behavior |
|---|---|
| Server available | Real-time validation |
| Server unavailable | Cached validation (7 days) |
| Cache expired | Grace period (3 days) |
| Grace expired | Product disabled |

## Compliance

### Compliance Checks

| Check | Frequency | Action |
|---|---|---|
| License validity | Each request | Block if invalid |
| Activation limits | Each activation | Prevent if exceeded |
| Expiration | Daily | Notify before expiry |
| Audit | Monthly | Usage report |

### Compliance Dashboard

```blade
<x-gsmui:license-compliance
    :licenses="$licenses"
    :compliance-status="$status"
/>
```

### Compliance Status

| Status | Description | Action |
|---|---|---|
| ✅ Compliant | All licenses valid | None |
| ⚠️ Warning | Expiration approaching | Renew |
| ❌ Non-compliant | Invalid license | Resolve |

## License Management

### Creator License Tools

| Tool | Description |
|---|---|
| Generate keys | Create new license keys |
| Bulk generate | Create multiple keys |
| Revoke keys | Disable license |
| Transfer keys | Move to new owner |
| Export keys | CSV/JSON export |

### License API

```php
// Create license
$license = GsmuiLicense::create([
    'product_id' => $productId,
    'type' => 'multi_site',
    'max_activations' => 5,
    'expires_at' => now()->addYear(),
]);

// Validate license
$valid = GsmuiLicense::validate($key, $productId);

// Deactivate
GsmuiLicense::deactivate($key, $projectId);
```

## License Configuration

```php
// config/marketplace.php
return [
    'licensing' => [
        'enabled' => true,
        'types' => [
            'single_site' => ['activations' => 1],
            'multi_site' => ['activations' => 5],
            'unlimited' => ['activations' => -1],
        ],
        'drm' => [
            'validation' => 'server',
            'fallback_days' => 7,
            'grace_days' => 3,
        ],
        'compliance' => [
            'check_frequency' => 'daily',
            'notify_expiry_days' => 30,
        ],
    ],
];
```
