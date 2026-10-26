---
title: Theme Marketplace
description: Theme listings, preview, installation, updates, and compatibility.
order: 15.2
group: Marketplace Themes
---

# Theme Marketplace

The GsmUi Theme Marketplace offers pre-built visual themes for rapid UI customization.

## Theme Features

| Feature | Description |
|---|---|
| Preview | Live theme preview before purchase |
| Install | One-click installation |
| Updates | Automatic update notifications |
| Compatibility | Version compatibility checking |
| Customization | Post-install theme overrides |

## Theme Listings

### Listing Display

```
┌─────────────────────────────────────────────┐
│ 🎨 Ocean Theme                             │
│ by ThemeStudio ⭐⭐⭐⭐⭐ (4.8)           │
├─────────────────────────────────────────────┤
│ [Preview Image]                             │
│                                             │
│ A calming blue theme with modern typography.│
│ Perfect for SaaS and data dashboards.       │
│                                             │
│ $39.00  |  [Preview]  |  [Buy]             │
│                                             │
│ ✓ Dark mode  ✓ RTL  ✓ RTL  ✓ 50+ tokens   │
│ Compatible: GsmUi 2.10+ | Laravel 10+      │
└─────────────────────────────────────────────┘
```

### Theme Metadata

| Field | Description |
|---|---|
| `name` | Theme name |
| `author` | Creator name |
| `price` | Theme price |
| `description` | Theme description |
| `preview_url` | Live preview |
| `screenshots` | Theme screenshots |
| `tokens` | Design tokens included |
| `variants` | Component variants |

## Theme Preview

### Preview Interface

```blade
<x-gsmui:theme-preview
    :theme="$theme"
    :components="['button', 'input', 'card', 'modal']"
    :show-code="true"
/>
```

### Preview Components

| Component | What to Show |
|---|---|
| Button | All variants and sizes |
| Input | All states (normal, focus, error, disabled) |
| Card | Various card layouts |
| Modal | Modal appearance |
| Table | Data table styling |
| Navigation | Sidebar and navbar |

### Preview Controls

| Control | Description |
|---|---|
| Theme toggle | Switch between themes |
| Dark mode | Preview dark variant |
| Responsive | Test different viewports |
| Component filter | Show specific components |

## Installation

### Install Process

```bash
# Via CLI
gsmui theme:install ocean-theme

# Via marketplace UI
# Click "Buy" → "Install" → "Activate"
```

### Installation Steps

| Step | Action |
|---|---|
| 1 | Download theme package |
| 2 | Extract to `resources/themes/` |
| 3 | Generate CSS variables |
| 4 | Compile assets |
| 5 | Activate theme |

### Install Confirmation

```blade
<x-gsmui:install-dialog
    :theme="$theme"
    wire:model="showInstall"
>
    <p>Install <strong>{{ $theme['name'] }}</strong>?</p>
    <p class="text-sm text-zinc-500">
        This will override your current theme settings.
    </p>
</x-gsmui:install-dialog>
```

## Theme Updates

### Update Notification

```blade
<x-gsmui:update-notification
    :theme="$theme"
    :current-version="$themeVersion"
    :latest-version="$latestVersion"
/>
```

### Update Process

| Step | Action |
|---|---|
| 1 | Check for updates |
| 2 | Download new version |
| 3 | Compare with current |
| 4 | Apply changes |
| 5 | Recompile assets |

### Update Options

| Option | Description |
|---|---|
| Auto-update | Apply automatically |
| Manual update | Notify only |
| Specific version | Target version |

## Compatibility

### Compatibility Matrix

| Theme | GsmUi | Laravel | PHP | Status |
|---|---|---|---|---|
| Ocean | 2.10+ | 10+ | 8.1+ | ✅ |
| Forest | 2.12+ | 10+ | 8.1+ | ✅ |
| Sunset | 2.8+ | 9+ | 8.0+ | ⚠️ |
| Classic | 2.5+ | 8+ | 7.4+ | ❌ |

### Compatibility Check

```php
$compatibility = GsmuiMarketplace::checkCompatibility($theme);

// Returns
[
    'compatible' => true,
    'requirements' => [
        'gsmui' => '>= 2.10',
        'laravel' => '>= 10.0',
        'php' => '>= 8.1',
    ],
    'warnings' => [],
]
```

## Theme Customization

### Post-Install Overrides

```css
/* resources/themes/custom.css */
:root {
    --gsmui-color-primary: #0ea5e9;
    --gsmui-radius: 0.75rem;
}
```

### Override Levels

| Level | Priority | Location |
|---|---|---|
| Theme defaults | 1 | Theme package |
| User overrides | 2 | `resources/themes/` |
| Component overrides | 3 | Component Blade |
| Inline styles | 4 | `style` attribute |

## Theme Management

### Active Theme Display

```
┌─────────────────────────────────────────────┐
│ Active Theme: Ocean                         │
│ Version: 2.1.0 | Updated: Jan 15, 2024     │
│                                             │
│ [Preview]  [Customize]  [Deactivate]       │
└─────────────────────────────────────────────┘
```

### Theme Actions

| Action | Description |
|---|---|
| Activate | Set as active theme |
| Deactivate | Remove from active |
| Customize | Override tokens |
| Export | Export customizations |
| Uninstall | Remove theme files |

## Marketplace Configuration

```php
// config/marketplace.php
return [
    'themes' => [
        'preview_enabled' => true,
        'auto_update' => false,
        'max_screenshots' => 8,
        'min_screenshot_width' => 1200,
        'allowed_formats' => ['png', 'jpg', 'webp'],
    ],
];
```
