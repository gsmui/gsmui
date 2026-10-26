---
title: Theme Marketplace Integration
description: Listing requirements, preview screenshots, update mechanism, and version management.
order: 16.9
group: Theme Marketplace
---

# Theme Marketplace Integration

The GsmUi Theme Engine integrates with the marketplace for theme distribution, updates, and version management.

## Integration Features

| Feature | Description |
|---|---|
| Listing requirements | Quality standards |
| Preview screenshots | Automated capture |
| Update mechanism | Auto-update support |
| Version management | Semantic versioning |
| License validation | DRM protection |

## Listing Requirements

### Required Fields

| Field | Type | Required | Description |
|---|---|---|---|
| `name` | string | Yes | Theme name |
| `description` | string | Yes | Short description |
| `author` | string | Yes | Creator name |
| `version` | string | Yes | Semantic version |
| `price` | number | Yes | Price in USD |
| `screenshots` | array | Yes | Min 3 images |
| `demo_url` | string | Yes | Live preview URL |
| `compatibility` | object | Yes | Version requirements |

### Quality Standards

| Criterion | Requirement |
|---|---|
| Token coverage | 100% of core tokens |
| Dark mode | Must include dark variant |
| Documentation | Complete README |
| Screenshots | Min 3, max 8 |
| Demo | Working demo URL |
| Code quality | PSR-12 compliant |
| License | Clear license terms |

### Listing Schema

```json
{
    "name": "Ocean Theme",
    "slug": "ocean-theme",
    "description": "A calming blue theme for modern apps",
    "author": "ThemeStudio",
    "version": "2.1.0",
    "price": 39.00,
    "category": "theme",
    "tags": ["blue", "dark-mode", "modern", "saas"],
    "screenshots": [
        "https://marketplace.gsmui.dev/screenshots/ocean-1.png",
        "https://marketplace.gsmui.dev/screenshots/ocean-2.png",
        "https://marketplace.gsmui.dev/screenshots/ocean-3.png"
    ],
    "demo_url": "https://demo.gsmui.dev/ocean",
    "compatibility": {
        "gsmui": ">=2.10.0",
        "laravel": ">=10.0",
        "php": ">=8.1"
    },
    "features": [
        "Dark mode",
        "RTL support",
        "50+ tokens",
        "Tailwind compatible"
    ]
}
```

## Preview Screenshots

### Screenshot Requirements

| Requirement | Specification |
|---|---|
| Format | PNG, JPG, WebP |
| Min width | 1200px |
| Max width | 2400px |
| Aspect ratio | 16:9 or 4:3 |
| Max size | 5MB per image |
| Min images | 3 |
| Max images | 8 |

### Screenshot Types

| Type | Description |
|---|---|
| Overview | Full page preview |
| Components | Component showcase |
| Dark mode | Dark variant |
| Mobile | Responsive preview |

### Automated Capture

```php
// Capture screenshots automatically
$screenshots = GsmuiTheme::captureScreenshots($theme, [
    'pages' => ['dashboard', 'components', 'auth'],
    'viewports' => ['desktop', 'tablet', 'mobile'],
    'modes' => ['light', 'dark'],
]);
```

### Screenshot Preview

```
┌─────────────────────────────────────────────┐
│ Screenshots: Ocean Theme                    │
├─────────────────────────────────────────────┤
│ ┌─────────────────────────────────────────┐│
│ │ [Dashboard Preview - Desktop Light]     ││
│ └─────────────────────────────────────────┘│
│ ┌───────────────┐ ┌───────────────────────┐│
│ │ [Components]  │ │ [Dark Mode]           ││
│ └───────────────┘ └───────────────────────┘│
│ ┌───────────────┐ ┌───────────────────────┐│
│ │ [Mobile]      │ │ [Auth Pages]          ││
│ └───────────────┘ └───────────────────────┘│
└─────────────────────────────────────────────┘
```

## Update Mechanism

### Update Check

```php
// Check for theme updates
$updates = GsmuiMarketplace::checkThemeUpdates();

// Returns
[
    [
        'theme' => 'ocean-theme',
        'current' => '2.0.0',
        'latest' => '2.1.0',
        'changelog' => 'Added new color tokens...',
        'download_url' => 'https://...',
    ],
]
```

### Auto-Update Process

```
Check for updates (daily)
    ↓
Compare versions
    ↓
Download update
    ↓
Validate compatibility
    ↓
Create backup
    ↓
Apply update
    ↓
Recompile assets
```

### Update Settings

```php
// config/marketplace.php
return [
    'theme_updates' => [
        'auto_check' => true,
        'check_frequency' => 'daily',
        'auto_install' => false,
        'notify' => true,
        'backup_before_update' => true,
    ],
];
```

### Update Dialog

```blade
<x-gsmui:theme-update-dialog
    :theme="$theme"
    :current-version="$currentVersion"
    :latest-version="$latestVersion"
    wire:model="showUpdate"
>
    <div class="space-y-4">
        <p>Update <strong>{{ $theme['name'] }}</strong> from {{ $currentVersion }} to {{ $latestVersion }}?</p>

        <div class="text-sm text-zinc-600">
            <h4 class="font-medium mb-2">Changelog:</h4>
            <ul class="list-disc pl-5">
                <li>Added new color tokens</li>
                <li>Improved dark mode contrast</li>
                <li>Fixed border radius on modals</li>
            </ul>
        </div>
    </div>
</x-gsmui:theme-update-dialog>
```

## Version Management

### Semantic Versioning

| Version Type | Example | Description |
|---|---|---|
| Major | 3.0.0 | Breaking changes |
| Minor | 2.1.0 | New features |
| Patch | 2.1.1 | Bug fixes |

### Version Requirements

```json
{
    "require": {
        "gsmui/gsmui-pro": ">=2.10.0",
        "php": ">=8.1",
        "laravel/framework": ">=10.0"
    },
    "provide": {
        "gsmui/theme": "2.1.0"
    }
}
```

### Version Compatibility Matrix

| Theme Version | GsmUi | Laravel | PHP | Status |
|---|---|---|---|---|
| 3.x | 3.0+ | 11+ | 8.2+ | Latest |
| 2.x | 2.10+ | 10+ | 8.1+ | Supported |
| 1.x | 2.5+ | 9+ | 8.0+ | Deprecated |

## License Validation

### Validation Flow

```
License key provided
    ↓
Validate with marketplace
    ↓
Check activation limit
    ↓
Verify expiration
    ↓
Return validation result
```

### License Types

| Type | Price | Activations | Updates |
|---|---|---|---|
| Single | $39 | 1 | 1 year |
| Multi | $79 | 5 | 1 year |
| Unlimited | $149 | Unlimited | Lifetime |

## Marketplace Configuration

```php
// config/marketplace.php
return [
    'theme_marketplace' => [
        'enabled' => true,
        'listing_requirements' => [
            'min_screenshots' => 3,
            'max_screenshots' => 8,
            'min_screenshot_width' => 1200,
            'require_demo' => true,
            'require_dark_mode' => true,
        ],
        'updates' => [
            'auto_check' => true,
            'check_frequency' => 'daily',
            'notify' => true,
        ],
        'licensing' => [
            'enabled' => true,
            'types' => ['single', 'multi', 'unlimited'],
        ],
    ],
];
```

## Publishing Workflow

### Publish Steps

```
Prepare theme package
    ↓
Validate requirements
    ↓
Capture screenshots
    ↓
Submit for review
    ↓
Review process (1-3 days)
    ↓
Approval / Revision
    ↓
Publish to marketplace
```

### Publishing API

```php
// Publish theme
$result = GsmuiMarketplace::publishTheme($theme, [
    'name' => 'Ocean Theme',
    'description' => 'A calming blue theme',
    'price' => 39.00,
    'category' => 'theme',
    'screenshots' => $screenshots,
    'demo_url' => 'https://demo.gsmui.dev/ocean',
]);

// Returns
[
    'success' => true,
    'theme_id' => 'ocean-theme',
    'status' => 'pending_review',
    'message' => 'Theme submitted for review',
]
```
