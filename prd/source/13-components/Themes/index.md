---
title: Component Theming
description: CSS variable system, theme tokens, dark mode, component variants, and the size system.
order: 13.4
group: Themes
---

# Component Theming

GsmUi uses a CSS custom property system for theming. All colors, spacing, typography, and component-level tokens are defined as CSS variables, enabling runtime theme switching without recompilation.

## CSS Variable System

Variables follow the `--gsmui-*` naming convention:

```css
:root {
    --gsmui-color-primary: #2563eb;
    --gsmui-color-primary-hover: #1d4ed8;
    --gsmui-color-surface: #ffffff;
    --gsmui-color-text: #18181b;
    --gsmui-radius: 0.5rem;
    --gsmui-shadow: 0 1px 2px rgba(0,0,0,0.05);
    --gsmui-font-sans: 'Inter', system-ui, sans-serif;
}
```

### Variable Categories

| Category | Prefix | Examples |
|---|---|---|
| Color | `--gsmui-color-*` | `primary`, `surface`, `text`, `border` |
| Spacing | `--gsmui-space-*` | `1` through `12` |
| Typography | `--gsmui-font-*` | `sans`, `mono`, `size-*` |
| Radius | `--gsmui-radius` | `sm`, `md`, `lg`, `full` |
| Shadow | `--gsmui-shadow` | `sm`, `md`, `lg` |
| Transition | `--gsmui-transition` | `fast`, `normal`, `slow` |
| Z-index | `--gsmui-z-*` | `dropdown`, `modal`, `toast` |

## Theme Tokens

Tokens are semantic aliases that map to raw values:

```css
[data-theme="default"] {
    --gsmui-token-bg-primary: var(--gsmui-color-blue-600);
    --gsmui-token-bg-secondary: var(--gsmui-color-zinc-100);
    --gsmui-token-text-primary: var(--gsmui-color-zinc-900);
    --gsmui-token-text-secondary: var(--gsmui-color-zinc-500);
    --gsmui-token-border: var(--gsmui-color-zinc-200);
}
```

### Token Layers

| Layer | Purpose | Example |
|---|---|---|
| Raw | Direct color values | `--gsmui-color-blue-600: #2563eb` |
| Semantic | Intent-based | `--gsmui-token-bg-primary` |
| Component | Component-specific | `--gsmui-button-bg` |
| Override | User customization | Highest precedence |

## Dark Mode

Dark mode uses `prefers-color-scheme` and manual toggle:

```css
@media (prefers-color-scheme: dark) {
    :root:not([data-theme]) {
        --gsmui-color-surface: #18181b;
        --gsmui-color-text: #fafafa;
        --gsmui-color-border: #27272a;
    }
}

[data-theme="dark"] {
    --gsmui-color-surface: #18181b;
    --gsmui-color-text: #fafafa;
    --gsmui-color-border: #27272a;
}
```

### Dark Mode Strategy

| Strategy | Behavior | Use Case |
|---|---|---|
| System | Follows OS setting | Default |
| Manual | Toggle via `data-theme` | User preference |
| Timed | Auto-switch by time | — |
| Class-based | `.dark` class on `<html>` | Legacy support |

## Component Variants

Each component inherits from base tokens and exposes variant tokens:

```css
/* Base */
.gsmui-button {
    background: var(--gsmui-button-bg, var(--gsmui-token-bg-primary));
    color: var(--gsmui-button-text, var(--gsmui-token-text-on-primary));
    border-radius: var(--gsmui-button-radius, var(--gsmui-radius));
}

/* Variant */
.gsmui-button[data-variant="secondary"] {
    --gsmui-button-bg: var(--gsmui-token-bg-secondary);
    --gsmui-button-text: var(--gsmui-token-text-primary);
}
```

### Component Token Map

| Component | Tokens |
|---|---|
| Button | `--gsmui-button-bg`, `--gsmui-button-text`, `--gsmui-button-radius`, `--gsmui-button-padding` |
| Input | `--gsmui-input-bg`, `--gsmui-input-border`, `--gsmui-input-text`, `--gsmui-input-placeholder` |
| Card | `--gsmui-card-bg`, `--gsmui-card-border`, `--gsmui-card-shadow`, `--gsmui-card-padding` |
| Modal | `--gsmui-modal-bg`, `--gsmui-modal-overlay`, `--gsmui-modal-shadow` |
| Table | `--gsmui-table-header-bg`, `--gsmui-table-row-hover`, `--gsmui-table-stripe` |

## Size System

Sizes are consistent across all components:

| Size | Height | Font | Padding | Radius |
|---|---|---|---|---|
| `xs` | `h-6` | `text-xs` | `px-2 py-1` | `rounded` |
| `sm` | `h-8` | `text-sm` | `px-2.5 py-1.5` | `rounded-md` |
| `md` | `h-10` | `text-sm` | `px-3 py-2` | `rounded-lg` |
| `lg` | `h-12` | `text-base` | `px-4 py-2.5` | `rounded-lg` |
| `xl` | `h-14` | `text-lg` | `px-5 py-3` | `rounded-xl` |

### Size Tokens

```css
:root {
    --gsmui-size-xs-height: 1.5rem;
    --gsmui-size-sm-height: 2rem;
    --gsmui-size-md-height: 2.5rem;
    --gsmui-size-lg-height: 3rem;
    --gsmui-size-xl-height: 3.5rem;
}
```

## Theme Configuration

```php
// config/gsmui-pro.php
return [
    'theme' => [
        'default' => 'default',
        'dark_mode' => 'system', // 'system', 'manual', 'disabled'
        'css_variables' => true,
        'prefix' => 'gsmui',
        'scales' => [
            'spacing' => 'default', // 'default', 'compact', 'comfortable'
            'radius' => 'default', // 'default', 'none', 'full'
            'font' => 'default', // 'default', 'dyslexic', 'mono'
        ],
    ],
];
```

## Custom Theme Example

```css
[data-theme="ocean"] {
    --gsmui-color-primary: #0891b2;
    --gsmui-color-primary-hover: #0e7490;
    --gsmui-color-surface: #f0fdfa;
    --gsmui-color-text: #164e63;
    --gsmui-color-border: #99f6e4;
    --gsmui-radius: 0.75rem;
}
```

## Class Merging API

```php
use Gsmui\Gsmui;

// Merge classes for a component
$classes = Gsmui::classes('button')
    ->merge(['custom-class'])
    ->variant('primary')
    ->size('md')
    ->state('disabled');

// Output: "gsmui-button gsmui-button--primary gsmui-button--md custom-class"
```

## Responsive Tokens

| Breakpoint | Token | Usage |
|---|---|---|
| `< 640px` | `--gsmui-breakpoint-sm` | Mobile adjustments |
| `640px–768px` | `--gsmui-breakpoint-md` | Tablet |
| `768px–1024px` | `--gsmui-breakpoint-lg` | Desktop |
| `> 1024px` | `--gsmui-breakpoint-xl` | Wide screens |

## Performance

| Metric | Target |
|---|---|
| CSS variable resolution | < 0.1ms |
| Theme switch | < 50ms |
| CSS bundle (all tokens) | < 8KB gzipped |
| Dark mode toggle | < 16ms (1 frame) |
