# 02 — Design Tokens

> The single source of truth for every visual value in the system.

---

## What Are Design Tokens?

Design tokens are named, platform-agnostic values that represent the atoms of your design system — colors, typography, spacing, shadows, and motion. They replace hard-coded values with semantic references that can be updated globally.

```css
/* Bad: Hard-coded value */
.card {
  background: #ffffff;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Good: Token-based */
.card {
  background: var(--gsmui-bg-surface);
  padding: var(--gsmui-space-4);
  border-radius: var(--gsmui-radius-lg);
  box-shadow: var(--gsmui-shadow-sm);
}
```

---

## Token Taxonomy

GsmUi uses a four-layer token architecture. Each layer has a distinct purpose and dependency direction.

### Layer Overview

```
┌─────────────────────────────────────────────┐
│  Component Tokens                           │  ← Most specific
│  (button-bg-primary, card-padding)          │
├─────────────────────────────────────────────┤
│  Alias / Semantic Tokens                    │
│  (bg-surface, text-primary, action-color)   │
├─────────────────────────────────────────────┤
│  Global Tokens                              │
│  (color-blue-500, space-4, text-lg)         │
├─────────────────────────────────────────────┤
│  Primitive Tokens                           │  ← Most generic
│  (raw hex values, pixel sizes)              │
└─────────────────────────────────────────────┘
```

### 1. Global Tokens (Primitive)

Raw, context-free values. They carry no meaning — only a value and a name.

| Token | Value |
|---|---|
| `--gsmui-color-blue-500` | `#3b82f6` |
| `--gsmui-color-blue-600` | `#2563eb` |
| `--gsmui-color-red-500` | `#ef4444` |
| `--gsmui-color-neutral-900` | `#111827` |
| `--gsmui-space-1` | `0.25rem` |
| `--gsmui-space-4` | `1rem` |
| `--gsmui-text-sm` | `0.875rem` |
| `--gsmui-radius-lg` | `0.5rem` |

Global tokens are never used directly in component styles. They exist only to be referenced by higher-level tokens.

### 2. Semantic (Alias) Tokens

Context-aware references to global tokens. They describe *purpose*, not *value*.

| Token | References | Usage |
|---|---|---|
| `--gsmui-bg-surface` | `--gsmui-color-white` | Card backgrounds, popovers |
| `--gsmui-bg-surface-dark` | `--gsmui-color-neutral-800` | Dark mode surfaces |
| `--gsmui-text-primary` | `--gsmui-color-neutral-900` | Headings, primary text |
| `--gsmui-text-secondary` | `--gsmui-color-neutral-500` | Captions, helper text |
| `--gsmui-text-on-primary` | `--gsmui-color-white` | Text on blue backgrounds |
| `--gsmui-border-default` | `--gsmui-color-neutral-200` | Default borders |
| `--gsmui-action-primary` | `--gsmui-color-blue-600` | Primary action color |
| `--gsmui-action-danger` | `--gsmui-color-red-600` | Destructive action color |
| `--gsmui-focus-ring` | `--gsmui-color-blue-500` | Focus indicator |

### 3. Component Tokens

Scoped to a specific component. They reference alias tokens, never global tokens directly.

| Token | References | Component |
|---|---|---|
| `--gsmui-button-bg-primary` | `--gsmui-action-primary` | Button |
| `--gsmui-button-text-primary` | `--gsmui-text-on-primary` | Button |
| `--gsmui-button-border-radius` | `--gsmui-radius-lg` | Button |
| `--gsmui-input-bg` | `--gsmui-bg-surface` | Input |
| `--gsmui-input-border` | `--gsmui-border-default` | Input |
| `--gsmui-input-padding-x` | `--gsmui-space-3` | Input |
| `--gsmui-card-bg` | `--gsmui-bg-surface` | Card |
| `--gsmui-card-padding` | `--gsmui-space-4` | Card |
| `--gsmui-card-shadow` | `--gsmui-shadow-sm` | Card |
| `--gsmui-popover-bg` | `--gsmui-bg-surface` | Popover |
| `--gsmui-popover-shadow` | `--gsmui-shadow-lg` | Popover |

### 4. Alias Tokens (Grouped)

A subset of alias tokens that group related semantic tokens for convenient theming.

| Alias Group | Tokens |
|---|---|
| `--gsmui-color-action` | `--gsmui-action-primary`, `--gsmui-action-hover`, `--gsmui-action-active` |
| `--gsmui-color-surface` | `--gsmui-bg-surface`, `--gsmui-bg-surface-raised`, `--gsmui-bg-surface-sunken` |
| `--gsmui-color-text` | `--gsmui-text-primary`, `--gsmui-text-secondary`, `--gsmui-text-tertiary`, `--gsmui-text-disabled` |
| `--gsmui-color-border` | `--gsmui-border-default`, `--gsmui-border-strong`, `--gsmui-border-subtle` |
| `--gsmui-color-feedback` | `--gsmui-feedback-success`, `--gsmui-feedback-warning`, `--gsmui-feedback-error`, `--gsmui-feedback-info` |

---

## Token Naming Convention

Tokens follow a strict naming pattern:

```
--gsmui-{category}-{property}-{variant}-{state}
```

### Structure

| Segment | Required | Examples |
|---|---|---|
| `--gsmui` | Yes | Namespace prefix |
| Category | Yes | `color`, `space`, `text`, `radius`, `shadow`, `duration` |
| Property | Conditional | `bg`, `text`, `border`, `padding`, `gap` |
| Variant | Conditional | `primary`, `secondary`, `lg`, `sm` |
| State | Conditional | `hover`, `active`, `focus`, `disabled` |

### Examples

```
--gsmui-color-blue-500          → global token
--gsmui-bg-surface              → semantic token
--gsmui-button-bg-primary       → component token
--gsmui-button-bg-primary-hover → component token with state
--gsmui-space-4                 → global spacing token
--gsmui-radius-lg               → global radius token
```

### Naming Rules

1. **Lowercase, hyphen-separated.** No camelCase, no underscores.
2. **No abbreviations.** Use `primary`, not `pri`. Use `secondary`, not `sec`.
3. **State suffixes are always last.** `hover`, `active`, `focus`, `disabled`.
4. **Variant before state.** `primary-hover`, not `hover-primary`.
5. **No component names in global/semantic tokens.** Reserve component prefixes for component tokens only.

---

## Token Inheritance

Tokens form a reference chain. When a token's value changes, every token that references it updates automatically.

### Inheritance Chain

```
--gsmui-color-blue-500: #3b82f6
    └─ references → --gsmui-action-primary
         └─ references → --gsmui-button-bg-primary
              └─ used by → .gsmui-button--primary { background: var(--gsmui-button-bg-primary) }
```

### Overriding Tokens

To theme a component, override at the component token level:

```css
/* Override the primary button color for a specific context */
.promo-section {
  --gsmui-button-bg-primary: var(--gsmui-color-purple-600);
}
```

This cascades correctly — the global token is unchanged, the alias token is unchanged, but the component token is overridden in the scoped context.

---

## CSS Variable Definitions

All tokens are defined as CSS custom properties on `:root`:

```css
:root {
  /* Global: Colors */
  --gsmui-color-blue-50: #eff6ff;
  --gsmui-color-blue-100: #dbeafe;
  --gsmui-color-blue-200: #bfdbfe;
  --gsmui-color-blue-300: #93c5fd;
  --gsmui-color-blue-400: #60a5fa;
  --gsmui-color-blue-500: #3b82f6;
  --gsmui-color-blue-600: #2563eb;
  --gsmui-color-blue-700: #1d4ed8;
  --gsmui-color-blue-800: #1e40af;
  --gsmui-color-blue-900: #1e3a8a;
  --gsmui-color-blue-950: #172554;

  /* Global: Spacing */
  --gsmui-space-0: 0;
  --gsmui-space-px: 1px;
  --gsmui-space-0_5: 0.125rem;
  --gsmui-space-1: 0.25rem;
  --gsmui-space-1_5: 0.375rem;
  --gsmui-space-2: 0.5rem;
  --gsmui-space-2_5: 0.625rem;
  --gsmui-space-3: 0.75rem;
  --gsmui-space-3_5: 0.875rem;
  --gsmui-space-4: 1rem;
  --gsmui-space-5: 1.25rem;
  --gsmui-space-6: 1.5rem;
  --gsmui-space-7: 1.75rem;
  --gsmui-space-8: 2rem;
  --gsmui-space-9: 2.25rem;
  --gsmui-space-10: 2.5rem;
  --gsmui-space-12: 3rem;
  --gsmui-space-14: 3.5rem;
  --gsmui-space-16: 4rem;
  --gsmui-space-20: 5rem;
  --gsmui-space-24: 6rem;
  --gsmui-space-28: 7rem;
  --gsmui-space-32: 8rem;
  --gsmui-space-36: 9rem;
  --gsmui-space-40: 10rem;
  --gsmui-space-44: 11rem;
  --gsmui-space-48: 12rem;
  --gsmui-space-52: 13rem;
  --gsmui-space-56: 14rem;
  --gsmui-space-60: 15rem;
  --gsmui-space-64: 16rem;
  --gsmui-space-72: 18rem;
  --gsmui-space-80: 20rem;
  --gsmui-space-96: 24rem;

  /* Global: Border Radius */
  --gsmui-radius-none: 0;
  --gsmui-radius-sm: 0.125rem;
  --gsmui-radius-md: 0.375rem;
  --gsmui-radius-lg: 0.5rem;
  --gsmui-radius-xl: 0.75rem;
  --gsmui-radius-2xl: 1rem;
  --gsmui-radius-3xl: 1.5rem;
  --gsmui-radius-full: 9999px;

  /* Semantic */
  --gsmui-bg-surface: #ffffff;
  --gsmui-bg-surface-raised: #ffffff;
  --gsmui-bg-sunken: #f9fafb;
  --gsmui-text-primary: #111827;
  --gsmui-text-secondary: #6b7280;
  --gsmui-text-tertiary: #9ca3af;
  --gsmui-text-disabled: #d1d5db;
  --gsmui-border-default: #e5e7eb;
  --gsmui-action-primary: #2563eb;
  --gsmui-focus-ring: #3b82f6;

  /* Shadows */
  --gsmui-shadow-xs: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --gsmui-shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
  --gsmui-shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
  --gsmui-shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
  --gsmui-shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);

  /* Duration */
  --gsmui-duration-75: 75ms;
  --gsmui-duration-100: 100ms;
  --gsmui-duration-150: 150ms;
  --gsmui-duration-200: 200ms;
  --gsmui-duration-300: 300ms;
  --gsmui-duration-500: 500ms;

  /* Easing */
  --gsmui-ease-default: cubic-bezier(0.4, 0, 0.2, 1);
  --gsmui-ease-in: cubic-bezier(0.4, 0, 1, 1);
  --gsmui-ease-out: cubic-bezier(0, 0, 0.2, 1);
  --gsmui-ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);
}
```

---

## Token Usage in Tailwind

Tokens map to Tailwind utility classes via `tailwind.config.js`:

```js
module.exports = {
  theme: {
    extend: {
      colors: {
        gsmui: {
          'action-primary': 'var(--gsmui-action-primary)',
          'bg-surface': 'var(--gsmui-bg-surface)',
          'text-primary': 'var(--gsmui-text-primary)',
        },
      },
      spacing: {
        'gsmui-1': 'var(--gsmui-space-1)',
        'gsmui-2': 'var(--gsmui-space-2)',
        'gsmui-3': 'var(--gsmui-space-3)',
        'gsmui-4': 'var(--gsmui-space-4)',
      },
      borderRadius: {
        'gsmui-lg': 'var(--gsmui-radius-lg)',
      },
    },
  },
}
```

---

## Token Auditing

Every component must be audited for hard-coded values. Use the following check:

```bash
# Find hard-coded color values in component styles
grep -rn '#[0-9a-fA-F]\{3,8\}' stubs/resources/views/gsmui/

# Find hard-coded pixel/rem values
grep -rn '[0-9]\+\.\?[0-9]*rem' stubs/resources/views/gsmui/
```

Any hard-coded value that should be a token is a bug. File an issue or add the token.

---

## Summary

| Layer | Purpose | Naming | Override? |
|---|---|---|---|
| Global | Raw values | `--gsmui-color-blue-500` | No |
| Semantic | Context | `--gsmui-bg-surface` | Via theming |
| Component | Scoped to element | `--gsmui-button-bg-primary` | Yes, via scoped CSS |
| Alias | Grouped theming | `--gsmui-color-action` | Yes, for full themes |

Tokens are the contract between design and code. Treat them as immutable infrastructure.
