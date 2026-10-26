---
title: Theme Presets
description: Default themes, industry presets, dark presets, and high-contrast presets.
order: 16.7
group: Presets
---

# Theme Presets

GsmUi ships with pre-built theme presets for common use cases and accessibility requirements.

## Preset Catalog

| Preset | Description | Use Case |
|---|---|---|
| Default | Clean, modern | General apps |
| Dark | Dark mode | Night mode |
| Ocean | Blue-toned | SaaS, dashboards |
| Forest | Green-toned | Nature, eco |
| Sunset | Warm tones | Creative, portfolio |
| High Contrast | Maximum contrast | Accessibility |
| Minimal | Stripped down | Performance |
| Corporate | Professional | Business apps |

## Default Preset

### Token Values

```css
:root {
    --gsmui-color-primary: #2563eb;
    --gsmui-color-primary-hover: #1d4ed8;
    --gsmui-color-surface: #ffffff;
    --gsmui-color-surface-alt: #f9fafb;
    --gsmui-color-text: #18181b;
    --gsmui-color-text-secondary: #71717a;
    --gsmui-color-border: #e4e4e7;
    --gsmui-radius: 0.5rem;
    --gsmui-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
```

### Preview

```
┌─────────────────────────────────────────────┐
│ Default Theme                               │
├─────────────────────────────────────────────┤
│                                             │
│ [Primary Button]  [Secondary Button]        │
│                                             │
│ ┌─────────────────────────────────────────┐│
│ │ Input field                            ││
│ └─────────────────────────────────────────┘│
│                                             │
│ ┌─────────────────────────────────────────┐│
│ │ Card with border                       ││
│ │ Clean, modern design                   ││
│ └─────────────────────────────────────────┘│
│                                             │
└─────────────────────────────────────────────┘
```

## Dark Preset

### Token Values

```css
[data-theme="dark"] {
    --gsmui-color-primary: #3b82f6;
    --gsmui-color-primary-hover: #60a5fa;
    --gsmui-color-surface: #18181b;
    --gsmui-color-surface-alt: #27272a;
    --gsmui-color-text: #fafafa;
    --gsmui-color-text-secondary: #a1a1aa;
    --gsmui-color-border: #27272a;
    --gsmui-radius: 0.5rem;
    --gsmui-shadow: 0 1px 2px rgba(0,0,0,0.3);
}
```

### Dark Mode Colors

| Token | Light | Dark | Purpose |
|---|---|---|---|
| `primary` | `#2563eb` | `#3b82f6` | Brand |
| `surface` | `#ffffff` | `#18181b` | Background |
| `surface-alt` | `#f9fafb` | `#27272a` | Alt background |
| `text` | `#18181b` | `#fafafa` | Body text |
| `border` | `#e4e4e7` | `#27272a` | Borders |

## Ocean Preset

### Token Values

```css
[data-theme="ocean"] {
    --gsmui-color-primary: #0891b2;
    --gsmui-color-primary-hover: #0e7490;
    --gsmui-color-primary-light: #cffafe;
    --gsmui-color-surface: #f0fdfa;
    --gsmui-color-surface-alt: #ccfbf1;
    --gsmui-color-text: #164e63;
    --gsmui-color-text-secondary: #0e7490;
    --gsmui-color-border: #99f6e4;
}
```

### Ocean Variants

| Variant | Color |
|---|---|
| Primary | `#0891b2` (Cyan 600) |
| Surface | `#f0fdfa` (Cyan 50) |
| Text | `#164e63` (Cyan 900) |
| Border | `#99f6e4` (Cyan 200) |

## Forest Preset

### Token Values

```css
[data-theme="forest"] {
    --gsmui-color-primary: #16a34a;
    --gsmui-color-primary-hover: #15803d;
    --gsmui-color-primary-light: #dcfce7;
    --gsmui-color-surface: #f0fdf4;
    --gsmui-color-surface-alt: #dcfce7;
    --gsmui-color-text: #14532d;
    --gsmui-color-text-secondary: #166534;
    --gsmui-color-border: #bbf7d0;
}
```

## Sunset Preset

### Token Values

```css
[data-theme="sunset"] {
    --gsmui-color-primary: #ea580c;
    --gsmui-color-primary-hover: #c2410c;
    --gsmui-color-primary-light: #fff7ed;
    --gsmui-color-surface: #fffbeb;
    --gsmui-color-surface-alt: #fef3c7;
    --gsmui-color-text: #78350f;
    --gsmui-color-text-secondary: #92400e;
    --gsmui-color-border: #fed7aa;
}
```

## High Contrast Preset

### Token Values

```css
[data-theme="high-contrast"] {
    --gsmui-color-primary: #0000ee;
    --gsmui-color-primary-hover: #0000cc;
    --gsmui-color-surface: #ffffff;
    --gsmui-color-surface-alt: #f0f0f0;
    --gsmui-color-text: #000000;
    --gsmui-color-text-secondary: #333333;
    --gsmui-color-border: #000000;
    --gsmui-radius: 0;
    --gsmui-shadow: none;
}
```

### Accessibility Features

| Feature | Implementation |
|---|---|
| Color contrast | > 7:1 ratio |
| Focus indicators | 3px solid outline |
| No shadows | Flat design |
| No gradients | Solid colors |
| Large text | Minimum 16px |

## Minimal Preset

### Token Values

```css
[data-theme="minimal"] {
    --gsmui-color-primary: #000000;
    --gsmui-color-primary-hover: #333333;
    --gsmui-color-surface: #ffffff;
    --gsmui-color-text: #000000;
    --gsmui-color-border: #e5e5e5;
    --gsmui-radius: 0;
    --gsmui-shadow: none;
}
```

## Corporate Preset

### Token Values

```css
[data-theme="corporate"] {
    --gsmui-color-primary: #1e40af;
    --gsmui-color-primary-hover: #1e3a8a;
    --gsmui-color-primary-light: #dbeafe;
    --gsmui-color-surface: #ffffff;
    --gsmui-color-surface-alt: #f8fafc;
    --gsmui-color-text: #0f172a;
    --gsmui-color-text-secondary: #475569;
    --gsmui-color-border: #cbd5e1;
    --gsmui-radius: 0.375rem;
}
```

## Preset Selection

### Preset Picker

```blade
<x-gsmui:preset-picker
    :presets="$availablePresets"
    :active="$currentPreset"
    wire:model="selectedPreset"
/>
```

### Preset Grid

```
┌─────────────────────────────────────────────┐
│ Select Theme Preset                         │
├─────────────────────────────────────────────┤
│ ┌──────────┐ ┌──────────┐ ┌──────────┐   │
│ │ Default  │ │ Dark     │ │ Ocean    │   │
│ │ [preview]│ │ [preview]│ │ [preview]│   │
│ └──────────┘ └──────────┘ └──────────┘   │
│ ┌──────────┐ ┌──────────┐ ┌──────────┐   │
│ │ Forest   │ │ Sunset   │ │ High     │   │
│ │ [preview]│ │ [preview]│ │ Contrast │   │
│ └──────────┘ └──────────┘ └──────────┘   │
│ ┌──────────┐ ┌──────────┐                 │
│ │ Minimal  │ │ Corporate│                 │
│ │ [preview]│ │ [preview]│                 │
│ └──────────┘ └──────────┘                 │
└─────────────────────────────────────────────┘
```

## Preset API

```php
use Gsmui\Theme\Presets;

// Get preset tokens
$tokens = Presets::get('ocean');

// List all presets
$presets = Presets::all();

// Apply preset
Presets::apply('ocean');

// Create custom preset from current theme
Presets::create('my-custom', $currentTokens);
```

## Preset Configuration

```php
// config/theme-engine.php
return [
    'presets' => [
        'enabled' => true,
        'default' => 'default',
        'available' => [
            'default', 'dark', 'ocean', 'forest',
            'sunset', 'high-contrast', 'minimal', 'corporate',
        ],
        'allow_custom' => true,
        'max_custom' => 20,
    ],
];
```
