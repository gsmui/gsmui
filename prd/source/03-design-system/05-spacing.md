# 05 — Spacing

> The consistent spatial relationships that create rhythm and clarity across GsmUi.

---

## Spacing Scale

GsmUi's spacing scale is built on a 4px (0.25rem) base unit. Every spacing value in the system derives from this scale.

| Token | Value | Rem | Pixels |
|---|---|---|---|
| `--gsmui-space-0` | 0 | 0 | 0 |
| `--gsmui-space-px` | 1px | — | 1 |
| `--gsmui-space-0_5` | 0.125rem | 0.125rem | 2 |
| `--gsmui-space-1` | 0.25rem | 0.25rem | 4 |
| `--gsmui-space-1_5` | 0.375rem | 0.375rem | 6 |
| `--gsmui-space-2` | 0.5rem | 0.5rem | 8 |
| `--gsmui-space-2_5` | 0.625rem | 0.625rem | 10 |
| `--gsmui-space-3` | 0.75rem | 0.75rem | 12 |
| `--gsmui-space-3_5` | 0.875rem | 0.875rem | 14 |
| `--gsmui-space-4` | 1rem | 1rem | 16 |
| `--gsmui-space-5` | 1.25rem | 1.25rem | 20 |
| `--gsmui-space-6` | 1.5rem | 1.5rem | 24 |
| `--gsmui-space-7` | 1.75rem | 1.75rem | 28 |
| `--gsmui-space-8` | 2rem | 2rem | 32 |
| `--gsmui-space-9` | 2.25rem | 2.25rem | 36 |
| `--gsmui-space-10` | 2.5rem | 2.5rem | 40 |
| `--gsmui-space-12` | 3rem | 3rem | 48 |
| `--gsmui-space-14` | 3.5rem | 3.5rem | 56 |
| `--gsmui-space-16` | 4rem | 4rem | 64 |
| `--gsmui-space-20` | 5rem | 5rem | 80 |
| `--gsmui-space-24` | 6rem | 6rem | 96 |
| `--gsmui-space-28` | 7rem | 7rem | 112 |
| `--gsmui-space-32` | 8rem | 8rem | 128 |
| `--gsmui-space-36` | 9rem | 9rem | 144 |
| `--gsmui-space-40` | 10rem | 10rem | 160 |
| `--gsmui-space-44` | 11rem | 11rem | 176 |
| `--gsmui-space-48` | 12rem | 12rem | 192 |
| `--gsmui-space-52` | 13rem | 13rem | 208 |
| `--gsmui-space-56` | 14rem | 14rem | 224 |
| `--gsmui-space-60` | 15rem | 15rem | 240 |
| `--gsmui-space-64` | 16rem | 16rem | 256 |
| `--gsmui-space-72` | 18rem | 18rem | 288 |
| `--gsmui-space-80` | 20rem | 20rem | 320 |
| `--gsmui-space-96` | 24rem | 24rem | 384 |

---

## Component Spacing

Every GsmUi component uses consistent internal spacing.

### Button Padding

| Size | Horizontal | Vertical | Min Width |
|---|---|---|---|
| `xs` | `space-2` (8px) | `space-1` (4px) | 48px |
| `sm` | `space-3` (12px) | `space-1_5` (6px) | 64px |
| `md` | `space-4` (16px) | `space-2` (8px) | 80px |
| `lg` | `space-5` (20px) | `space-2_5` (10px) | 96px |
| `xl` | `space-6` (24px) | `space-3` (12px) | 112px |

### Input Padding

| Size | Horizontal | Vertical | Height |
|---|---|---|---|
| `xs` | `space-2` (8px) | `space-1` (4px) | 24px |
| `sm` | `space-2_5` (10px) | `space-1_5` (6px) | 32px |
| `md` | `space-3` (12px) | `space-2` (8px) | 40px |
| `lg` | `space-3_5` (14px) | `space-2_5` (10px) | 48px |

### Card Padding

| Size | Padding |
|---|---|
| `sm` | `space-3` (12px) |
| `md` | `space-4` (16px) |
| `lg` | `space-6` (24px) |
| `xl` | `space-8` (32px) |

### Dialog / Modal Padding

| Area | Padding |
|---|---|
| Content area | `space-6` (24px) |
| Footer | `space-4` (16px) horizontal, `space-6` (24px) vertical |
| Close button | `space-4` (16px) absolute positioned |

---

## Layout Spacing

### Page Layout

| Element | Spacing |
|---|---|
| Page top padding | `space-8` (32px) |
| Page bottom padding | `space-12` (48px) |
| Page horizontal padding | `space-4` to `space-8` (16–32px) responsive |
| Section vertical spacing | `space-16` to `space-24` (64–96px) |
| Sidebar width | `space-64` (256px) |
| Content max width | `space-80` (320px) — *note: actual max-width is 1280px* |

### Grid Gutters

| Breakpoint | Gutter |
|---|---|
| Mobile (< 640px) | `space-4` (16px) |
| Tablet (640–1024px) | `space-5` (20px) |
| Desktop (> 1024px) | `space-6` (24px) |
| Wide (> 1280px) | `space-8` (32px) |

### Stack Spacing (Vertical Rhythm)

| Context | Gap |
|---|---|
| Form fields | `space-4` (16px) |
| Card grid | `space-4` (16px) |
| List items | `space-1` (4px) |
| Navigation items | `space-0_5` (2px) |
| Inline element group | `space-2` (8px) |
| Section separator | `space-8` to `space-12` (32–48px) |

---

## Padding and Margin Conventions

### Component-Level Padding

Components use only horizontal and vertical padding, never margin. Margin is reserved for layout positioning.

```css
/* Good: Padding on the component */
.gsmui-card {
  padding: var(--gsmui-space-4);
}

/* Good: Margin for layout separation */
.gsmui-card + .gsmui-card {
  margin-top: var(--gsmui-space-4);
}

/* Bad: Margin on the component itself */
.gsmui-card {
  margin: var(--gsmui-space-4); /* Don't do this */
}
```

### External vs Internal Spacing

| Concept | Rule | Example |
|---|---|---|
| Internal spacing | Always `padding` | Card content, button label |
| Spacing between siblings | Use `gap` or sibling combinator | `gap: var(--gsmui-space-4)` |
| Spacing from parent | Use parent's `padding` | Modal content area |
| One-off positioning | Use `margin` sparingly | Separator line margin |

---

## Density Modes

GsmUi supports three density modes to adapt spacing for different contexts.

### Compact

For data-dense interfaces: tables, dashboards, admin panels.

| Property | Value |
|---|---|
| Base unit | 3px (0.1875rem) |
| Component padding | 75% of default |
| Gap | 75% of default |
| Font size adjustment | -1 step (base → sm) |

### Default

Standard spacing for most interfaces.

| Property | Value |
|---|---|
| Base unit | 4px (0.25rem) |
| Component padding | 100% (baseline) |
| Gap | 100% (baseline) |
| Font size adjustment | None |

### Comfortable

For content-heavy interfaces: articles, documentation, reading views.

| Property | Value |
|---|---|
| Base unit | 4px (0.25rem) |
| Component padding | 125% of default |
| Gap | 125% of default |
| Font size adjustment | +1 step (base → lg) |

### Density CSS Variables

```css
:root {
  --gsmui-density-multiplier: 1;
}

/* Compact mode */
.density-compact {
  --gsmui-density-multiplier: 0.75;
  --gsmui-space-1: 0.1875rem;
  --gsmui-space-2: 0.375rem;
  --gsmui-space-3: 0.5625rem;
  --gsmui-space-4: 0.75rem;
}

/* Comfortable mode */
.density-comfortable {
  --gsmui-density-multiplier: 1.25;
  --gsmui-space-1: 0.3125rem;
  --gsmui-space-2: 0.625rem;
  --gsmui-space-3: 0.9375rem;
  --gsmui-space-4: 1.25rem;
}
```

### Density Usage

```blade
{{-- Compact table --}}
<x-gsmui:table density="compact">
  ...columns...
</x-gsmui:table>

{{-- Comfortable reading view --}}
<div class="gsmui-prose density-comfortable">
  ...long-form content...
</div>
```

---

## Tailwind Utilities

All spacing tokens map to standard Tailwind utilities:

```html
<!-- Padding -->
<div class="p-4">16px all sides</div>
<div class="px-4 py-2">16px horizontal, 8px vertical</div>
<div class="ps-4">16px inline start (logical)</div>

<!-- Margin -->
<div class="mt-4">16px top</div>
<div class="mx-auto">centered</div>

<!-- Gap -->
<div class="flex gap-4">16px between flex children</div>
<div class="grid gap-6">24px between grid children</div>

<!-- Size -->
<div class="w-64">256px width</div>
<div class="h-32">128px height</div>
```

---

## Spacing Audit Checklist

When reviewing component spacing, verify:

1. **No magic numbers.** Every value references a token.
2. **Consistent component padding.** Same component type = same padding.
3. **Consistent gaps.** Same context = same gap between siblings.
4. **No margin collapse surprises.** Use `gap` where possible.
5. **Density mode support.** Spacing respects the density multiplier.

```bash
# Find hard-coded spacing values
grep -rn 'padding:\|margin:\|gap:' stubs/resources/views/gsmui/ | grep -v 'var(--gsmui'
```

---

## Summary

| Concept | Scale | Usage |
|---|---|---|
| Base unit | 4px (0.25rem) | Foundation of the scale |
| Component padding | `space-2` to `space-8` | Internal component spacing |
| Layout gaps | `space-1` to `space-6` | Space between siblings |
| Section spacing | `space-12` to `space-24` | Space between major sections |
| Page spacing | `space-8` to `space-12` | Page-level padding |
| Density modes | 0.75x / 1x / 1.25x | Compact / Default / Comfortable |

Consistent spacing creates visual rhythm. Rhythm creates trust.
