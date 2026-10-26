---
title: Design Tokens
description: Token categories, token naming, token inheritance, and token overrides.
order: 16.2
group: Tokens
---

# Design Tokens

Design tokens are the atomic values that define the visual language of GsmUi themes.

## Token Overview

| Category | Prefix | Examples |
|---|---|---|
| Color | `--gsmui-color-*` | `primary`, `surface`, `text` |
| Spacing | `--gsmui-space-*` | `1`, `2`, `3`, `4` |
| Typography | `--gsmui-font-*` | `sans`, `mono`, `size-*` |
| Radius | `--gsmui-radius` | `sm`, `md`, `lg`, `full` |
| Shadow | `--gsmui-shadow` | `sm`, `md`, `lg` |
| Z-index | `--gsmui-z-*` | `dropdown`, `modal`, `toast` |
| Transition | `--gsmui-transition` | `fast`, `normal`, `slow` |

## Token Categories

### Color Tokens

```css
:root {
    /* Raw Colors */
    --gsmui-color-blue-50: #eff6ff;
    --gsmui-color-blue-100: #dbeafe;
    --gsmui-color-blue-500: #3b82f6;
    --gsmui-color-blue-600: #2563eb;
    --gsmui-color-blue-700: #1d4ed8;

    /* Semantic Colors */
    --gsmui-color-primary: var(--gsmui-color-blue-600);
    --gsmui-color-primary-hover: var(--gsmui-color-blue-700);
    --gsmui-color-surface: #ffffff;
    --gsmui-color-text: #18181b;
    --gsmui-color-border: #e4e4e7;
}
```

### Color Token Map

| Token | Light | Dark | Purpose |
|---|---|---|---|
| `primary` | `#2563eb` | `#3b82f6` | Brand color |
| `surface` | `#ffffff` | `#18181b` | Background |
| `text` | `#18181b` | `#fafafa` | Body text |
| `border` | `#e4e4e7` | `#27272a` | Borders |
| `muted` | `#71717a` | `#a1a1aa` | Secondary text |

### Spacing Tokens

```css
:root {
    --gsmui-space-0: 0;
    --gsmui-space-1: 0.25rem;   /* 4px */
    --gsmui-space-2: 0.5rem;    /* 8px */
    --gsmui-space-3: 0.75rem;   /* 12px */
    --gsmui-space-4: 1rem;      /* 16px */
    --gsmui-space-5: 1.25rem;   /* 20px */
    --gsmui-space-6: 1.5rem;    /* 24px */
    --gsmui-space-8: 2rem;      /* 32px */
    --gsmui-space-10: 2.5rem;   /* 40px */
    --gsmui-space-12: 3rem;     /* 48px */
}
```

### Spacing Scale

| Token | Value | Pixels |
|---|---|---|
| `space-1` | `0.25rem` | 4px |
| `space-2` | `0.5rem` | 8px |
| `space-3` | `0.75rem` | 12px |
| `space-4` | `1rem` | 16px |
| `space-6` | `1.5rem` | 24px |
| `space-8` | `2rem` | 32px |
| `space-12` | `3rem` | 48px |

### Typography Tokens

```css
:root {
    /* Font Families */
    --gsmui-font-sans: 'Inter', system-ui, sans-serif;
    --gsmui-font-mono: 'JetBrains Mono', monospace;

    /* Font Sizes */
    --gsmui-text-xs: 0.75rem;    /* 12px */
    --gsmui-text-sm: 0.875rem;   /* 14px */
    --gsmui-text-base: 1rem;     /* 16px */
    --gsmui-text-lg: 1.125rem;   /* 18px */
    --gsmui-text-xl: 1.25rem;    /* 20px */
    --gsmui-text-2xl: 1.5rem;    /* 24px */

    /* Font Weights */
    --gsmui-font-normal: 400;
    --gsmui-font-medium: 500;
    --gsmui-font-semibold: 600;
    --gsmui-font-bold: 700;
}
```

### Radius Tokens

```css
:root {
    --gsmui-radius-none: 0;
    --gsmui-radius-sm: 0.25rem;   /* 4px */
    --gsmui-radius-md: 0.375rem;  /* 6px */
    --gsmui-radius-lg: 0.5rem;    /* 8px */
    --gsmui-radius-xl: 0.75rem;   /* 12px */
    --gsmui-radius-2xl: 1rem;     /* 16px */
    --gsmui-radius-full: 9999px;
}
```

### Shadow Tokens

```css
:root {
    --gsmui-shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
    --gsmui-shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    --gsmui-shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
    --gsmui-shadow-xl: 0 20px 25px rgba(0,0,0,0.15);
}
```

## Token Naming

### Naming Convention

```
--gsmui-{category}-{property}-{variant}-{state}
```

### Examples

| Token | Category | Property | Variant | State |
|---|---|---|---|---|
| `--gsmui-color-primary-hover` | color | primary | — | hover |
| `--gsmui-button-bg-primary` | button | bg | primary | — |
| `--gsmui-input-border-focus` | input | border | — | focus |
| `--gsmui-text-size-lg` | text | size | lg | — |

### Naming Rules

| Rule | Description |
|---|---|
| kebab-case | Use hyphens |
| Lowercase | Always lowercase |
| No abbreviations | Write full words |
| Semantic | Purpose over value |

## Token Inheritance

### Inheritance Chain

```
Raw Value
    ↓
Semantic Token
    ↓
Component Token
    ↓
Override Token
```

### Inheritance Example

```css
/* Raw */
--gsmui-color-blue-600: #2563eb;

/* Semantic */
--gsmui-color-primary: var(--gsmui-color-blue-600);

/* Component */
--gsmui-button-bg: var(--gsmui-color-primary);

/* Override */
--gsmui-button-bg: #10b981; /* Custom green */
```

## Token Overrides

### Override Levels

| Level | Priority | Location |
|---|---|---|
| Theme defaults | 1 | Theme package |
| User overrides | 2 | `resources/themes/` |
| Component overrides | 3 | Component Blade |
| Inline overrides | 4 | `style` attribute |

### Override Example

```css
/* resources/themes/custom.css */
:root {
    /* Override primary color */
    --gsmui-color-primary: #10b981;
    --gsmui-color-primary-hover: #059669;

    /* Override radius */
    --gsmui-radius-lg: 1rem;
}
```

## Token API

### PHP API

```php
use Gsmui\Theme\Tokens;

// Get token value
$primary = Tokens::get('color.primary');

// Get all tokens
$tokens = Tokens::all();

// Override token
Tokens::set('color.primary', '#10b981');

// Export tokens as CSS
$css = Tokens::toCss();
```

### Blade API

```blade
{{-- Get token value --}}
{{ Gsmui::token('color.primary') }}

{{-- Apply token as class --}}
<div class="{{ Gsmui::tokenClass('color.primary') }}">
```

## Token Configuration

```php
// config/theme-engine.php
return [
    'tokens' => [
        'prefix' => 'gsmui',
        'categories' => ['color', 'spacing', 'typography', 'radius', 'shadow', 'z-index'],
        'dark_mode' => 'class', // 'class', 'media', 'attribute'
        'override_levels' => 4,
    ],
];
```
