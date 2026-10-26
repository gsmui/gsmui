# 03 — Color System

> The palette, scales, and semantic mappings that define GsmUi's visual identity.

---

## Color Philosophy

GsmUi's color system is built on three pillars:

1. **A single primary hue** (blue) anchors the brand identity.
2. **Semantic aliases** decouple meaning from raw color values.
3. **Dark mode** is a first-class citizen, not an afterthought.

Colors are never used raw. Every color reference goes through a token.

---

## Primary Palette (Blue)

The primary palette is used for interactive elements, links, focus rings, and primary actions.

| Scale | Token | Hex | Usage |
|---|---|---|---|
| 50 | `--gsmui-color-blue-50` | `#eff6ff` | Light backgrounds, hover states |
| 100 | `--gsmui-color-blue-100` | `#dbeafe` | Selected row backgrounds |
| 200 | `--gsmui-color-blue-200` | `#bfdbfe` | Borders on selected items |
| 300 | `--gsmui-color-blue-300` | `#93c5fd` | Disabled primary elements |
| 400 | `--gsmui-color-blue-400` | `#60a5fa` | Hover state for icons |
| 500 | `--gsmui-color-blue-500` | `#3b82f6` | Default primary color |
| 600 | `--gsmui-color-blue-600` | `#2563eb` | Action buttons, links |
| 700 | `--gsmui-color-blue-700` | `#1d4ed8` | Hover state for primary |
| 800 | `--gsmui-color-blue-800` | `#1e40af` | Active state for primary |
| 900 | `--gsmui-color-blue-900` | `#1e3a8a` | Text on light blue backgrounds |
| 950 | `--gsmui-color-blue-950` | `#172554` | Darkest blue accent |

---

## Secondary Palette (Violet)

Secondary palette is used sparingly for emphasis, badges, and premium features.

| Scale | Token | Hex | Usage |
|---|---|---|---|
| 50 | `--gsmui-color-violet-50` | `#f5f3ff` | Light violet backgrounds |
| 100 | `--gsmui-color-violet-100` | `#ede9fe` | Badge backgrounds |
| 200 | `--gsmui-color-violet-200` | `#ddd6fe` | Light borders |
| 300 | `--gsmui-color-violet-300` | `#c4b5fd` | Subtle accents |
| 400 | `--gsmui-color-violet-400` | `#a78bfa` | Icon color |
| 500 | `--gsmui-color-violet-500` | `#8b5cf6` | Default secondary |
| 600 | `--gsmui-color-violet-600` | `#7c3aed` | Secondary actions |
| 700 | `--gsmui-color-violet-700` | `#6d28d9` | Hover secondary |
| 800 | `--gsmui-color-violet-800` | `#5b21b6` | Active secondary |
| 900 | `--gsmui-color-violet-900` | `#4c1d95` | Dark violet text |
| 950 | `--gsmui-color-violet-950` | `#2e1065` | Deepest violet |

---

## Accent Palette (Amber)

Accent palette draws attention to highlights, promotions, and notification badges.

| Scale | Token | Hex | Usage |
|---|---|---|---|
| 50 | `--gsmui-color-amber-50` | `#fffbeb` | Light warm backgrounds |
| 100 | `--gsmui-color-amber-100` | `#fef3c7` | Tooltip backgrounds |
| 200 | `--gsmui-color-amber-200` | `#fde68a` | Light amber borders |
| 300 | `--gsmui-color-amber-300` | `#fcd34d` | Subtle highlights |
| 400 | `--gsmui-color-amber-400` | `#fbbf24` | Icon highlights |
| 500 | `--gsmui-color-amber-500` | `#f59e0b` | Default accent |
| 600 | `--gsmui-color-amber-600` | `#d97706` | Accent actions |
| 700 | `--gsmui-color-amber-700` | `#b45309` | Hover accent |
| 800 | `--gsmui-color-amber-800` | `#92400e` | Active accent |
| 900 | `--gsmui-color-amber-900` | `#78350f` | Dark amber text |
| 950 | `--gsmui-color-amber-950` | `#451a03` | Deepest amber |

---

## Neutral Palette

Neutral palette forms the foundation for text, borders, backgrounds, and surfaces.

| Scale | Token | Hex | Usage |
|---|---|---|---|
| 50 | `--gsmui-color-neutral-50` | `#f9fafb` | Page background |
| 100 | `--gsmui-color-neutral-100` | `#f3f4f6` | Subtle backgrounds |
| 200 | `--gsmui-color-neutral-200` | `#e5e7eb` | Default borders |
| 300 | `--gsmui-color-neutral-300` | `#d1d5db` | Disabled borders |
| 400 | `--gsmui-color-neutral-400` | `#9ca3af` | Placeholder text |
| 500 | `--gsmui-color-neutral-500` | `#6b7280` | Secondary text |
| 600 | `--gsmui-color-neutral-600` | `#4b5563` | Tertiary text |
| 700 | `--gsmui-color-neutral-700` | `#374151` | Muted text |
| 800 | `--gsmui-color-neutral-800` | `#1f2937` | Dark mode surfaces |
| 900 | `--gsmui-color-neutral-900` | `#111827` | Primary text |
| 950 | `--gsmui-color-neutral-950` | `#030712` | Deepest black |

---

## Feedback Colors

### Success (Green)

| Token | Hex | Usage |
|---|---|---|
| `--gsmui-color-success-50` | `#f0fdf4` | Success background |
| `--gsmui-color-success-100` | `#dcfce7` | Success border |
| `--gsmui-color-success-200` | `#bbf7d0` | Light success |
| `--gsmui-color-success-300` | `#86efac` | Success icons |
| `--gsmui-color-success-400` | `#4ade80` | Success accent |
| `--gsmui-color-success-500` | `#22c55e` | Success default |
| `--gsmui-color-success-600` | `#16a34a` | Success actions |
| `--gsmui-color-success-700` | `#15803d` | Hover success |
| `--gsmui-color-success-800` | `#166534` | Active success |
| `--gsmui-color-success-900` | `#14532d` | Dark success text |

### Warning (Amber)

Already defined in Accent palette. Aliased as:

| Token | References |
|---|---|
| `--gsmui-feedback-warning` | `--gsmui-color-amber-500` |
| `--gsmui-feedback-warning-bg` | `--gsmui-color-amber-50` |
| `--gsmui-feedback-warning-border` | `--gsmui-color-amber-200` |

### Error (Red)

| Token | Hex | Usage |
|---|---|---|
| `--gsmui-color-error-50` | `#fef2f2` | Error background |
| `--gsmui-color-error-100` | `#fee2e2` | Error border |
| `--gsmui-color-error-200` | `#fecaca` | Light error |
| `--gsmui-color-error-300` | `#fca5a5` | Error icons |
| `--gsmui-color-error-400` | `#f87171` | Error accent |
| `--gsmui-color-error-500` | `#ef4444` | Error default |
| `--gsmui-color-error-600` | `#dc2626` | Error actions |
| `--gsmui-color-error-700` | `#b91c1c` | Hover error |
| `--gsmui-color-error-800` | `#991b1b` | Active error |
| `--gsmui-color-error-900` | `#7f1d1d` | Dark error text |

### Info (Sky)

| Token | Hex | Usage |
|---|---|---|
| `--gsmui-color-info-50` | `#f0f9ff` | Info background |
| `--gsmui-color-info-100` | `#e0f2fe` | Info border |
| `--gsmui-color-info-200` | `#bae6fd` | Light info |
| `--gsmui-color-info-300` | `#7dd3fc` | Info icons |
| `--gsmui-color-info-400` | `#38bdf8` | Info accent |
| `--gsmui-color-info-500` | `#0ea5e9` | Info default |
| `--gsmui-color-info-600` | `#0284c7` | Info actions |
| `--gsmui-color-info-700` | `#0369a1` | Hover info |
| `--gsmui-color-info-800` | `#075985` | Active info |
| `--gsmui-color-info-900` | `#0c4a6e` | Dark info text |

---

## CSS Variables — Light Mode

```css
:root {
  /* Backgrounds */
  --gsmui-bg-page: var(--gsmui-color-neutral-50);
  --gsmui-bg-surface: #ffffff;
  --gsmui-bg-surface-raised: #ffffff;
  --gsmui-bg-sunken: var(--gsmui-color-neutral-100);

  /* Text */
  --gsmui-text-primary: var(--gsmui-color-neutral-900);
  --gsmui-text-secondary: var(--gsmui-color-neutral-500);
  --gsmui-text-tertiary: var(--gsmui-color-neutral-400);
  --gsmui-text-disabled: var(--gsmui-color-neutral-300);
  --gsmui-text-inverse: #ffffff;

  /* Borders */
  --gsmui-border-default: var(--gsmui-color-neutral-200);
  --gsmui-border-strong: var(--gsmui-color-neutral-300);
  --gsmui-border-subtle: var(--gsmui-color-neutral-100);

  /* Actions */
  --gsmui-action-primary: var(--gsmui-color-blue-600);
  --gsmui-action-primary-hover: var(--gsmui-color-blue-700);
  --gsmui-action-primary-active: var(--gsmui-color-blue-800);
  --gsmui-action-danger: var(--gsmui-color-error-600);
  --gsmui-action-danger-hover: var(--gsmui-color-error-700);
  --gsmui-action-danger-active: var(--gsmui-color-error-800);

  /* Focus */
  --gsmui-focus-ring: var(--gsmui-color-blue-500);
  --gsmui-focus-ring-offset: #ffffff;

  /* Shadows */
  --gsmui-shadow-color: 0deg 0% 0%;
}
```

---

## CSS Variables — Dark Mode

```css
.dark {
  /* Backgrounds */
  --gsmui-bg-page: #0a0a0b;
  --gsmui-bg-surface: var(--gsmui-color-neutral-800);
  --gsmui-bg-surface-raised: var(--gsmui-color-neutral-700);
  --gsmui-bg-sunken: #000000;

  /* Text */
  --gsmui-text-primary: var(--gsmui-color-neutral-50);
  --gsmui-text-secondary: var(--gsmui-color-neutral-400);
  --gsmui-text-tertiary: var(--gsmui-color-neutral-500);
  --gsmui-text-disabled: var(--gsmui-color-neutral-600);
  --gsmui-text-inverse: var(--gsmui-color-neutral-900);

  /* Borders */
  --gsmui-border-default: var(--gsmui-color-neutral-700);
  --gsmui-border-strong: var(--gsmui-color-neutral-600);
  --gsmui-border-subtle: var(--gsmui-color-neutral-800);

  /* Actions */
  --gsmui-action-primary: var(--gsmui-color-blue-500);
  --gsmui-action-primary-hover: var(--gsmui-color-blue-400);
  --gsmui-action-primary-active: var(--gsmui-color-blue-300);
  --gsmui-action-danger: var(--gsmui-color-error-500);
  --gsmui-action-danger-hover: var(--gsmui-color-error-400);
  --gsmui-action-danger-active: var(--gsmui-color-error-300);

  /* Focus */
  --gsmui-focus-ring: var(--gsmui-color-blue-400);
  --gsmui-focus-ring-offset: var(--gsmui-color-neutral-900);

  /* Shadows */
  --gsmui-shadow-color: 0deg 0% 0%;
}
```

---

## Tailwind Integration

```js
// tailwind.config.js
module.exports = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        gsmui: {
          // Semantic aliases
          'bg-page': 'var(--gsmui-bg-page)',
          'bg-surface': 'var(--gsmui-bg-surface)',
          'bg-surface-raised': 'var(--gsmui-bg-surface-raised)',
          'bg-sunken': 'var(--gsmui-bg-sunken)',
          'text-primary': 'var(--gsmui-text-primary)',
          'text-secondary': 'var(--gsmui-text-secondary)',
          'text-tertiary': 'var(--gsmui-text-tertiary)',
          'text-disabled': 'var(--gsmui-text-disabled)',
          'text-inverse': 'var(--gsmui-text-inverse)',
          'border-default': 'var(--gsmui-border-default)',
          'border-strong': 'var(--gsmui-border-strong)',
          'border-subtle': 'var(--gsmui-border-subtle)',
          'action-primary': 'var(--gsmui-action-primary)',
          'action-primary-hover': 'var(--gsmui-action-primary-hover)',
          'action-danger': 'var(--gsmui-action-danger)',
          'focus-ring': 'var(--gsmui-focus-ring)',
          // Feedback
          success: 'var(--gsmui-feedback-success)',
          warning: 'var(--gsmui-feedback-warning)',
          error: 'var(--gsmui-feedback-error)',
          info: 'var(--gsmui-feedback-info)',
        },
      },
    },
  },
}
```

---

## Color Usage Rules

### Do

- Use semantic tokens, not raw colors: `text-gsmui-text-primary` not `text-gray-900`.
- Use the 50–950 scale only for new token definitions, not in component styles.
- Test all color combinations for WCAG AA contrast.
- Use `currentColor` for icons to inherit text color.

### Don't

- Never use `text-white` on light backgrounds.
- Never use raw hex values in component markup.
- Never assume a color looks the same in dark mode — always define both.
- Never use color as the only way to communicate state.

---

## Contrast Ratios

| Foreground | Background | Ratio | Passes AA? |
|---|---|---|---|
| Neutral-900 | White | 17.36:1 | Yes |
| Neutral-500 | White | 4.65:1 | Yes |
| Neutral-400 | White | 3.03:1 | No (large text only) |
| Blue-600 | White | 4.63:1 | Yes |
| Blue-500 | White | 3.40:1 | No (large text only) |
| Error-600 | White | 4.59:1 | Yes |
| White | Blue-600 | 4.63:1 | Yes |
| White | Neutral-900 | 17.36:1 | Yes |
| White | Neutral-800 | 10.69:1 | Yes |

Use the WebAIM Contrast Checker to verify any new color combinations.
