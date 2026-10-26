# 06 — Icons

> The icon system, sizing conventions, and usage guidelines for GsmUi.

---

## Icon Library

GsmUi integrates with [Heroicons](https://heroicons.com/) as its primary icon library. Heroicons provide a consistent, well-designed set of 300+ SVG icons created by the Tailwind CSS team.

### Icon Sources

| Source | License | Icons | Usage |
|---|---|---|---|
| Heroicons | MIT | 300+ | Primary icon set |
| Custom SVGs | Per-project | Unlimited | Domain-specific icons |

### Why Heroicons

- Consistent 24×24 viewBox across all icons
- Three styles: outline (default), solid, mini
- Actively maintained by the Tailwind team
- MIT licensed, free for commercial use
- Well-documented and searchable at heroicons.com

---

## Icon Sizes

Every icon in GsmUi exists at four sizes. The size determines the viewBox container and the rendered dimensions.

| Size | Token | Container | Icon SVG | Usage |
|---|---|---|---|---|
| `sm` | `--gsmui-icon-sm` | 16×16 | 20×20 viewBox | Inline with text, badges |
| `md` | `--gsmui-icon-md` | 20×20 | 24×24 viewBox | Default icon size |
| `lg` | `--gsmui-icon-lg` | 24×24 | 24×24 viewBox | Standalone icons |
| `xl` | `--gsmui-icon-xl` | 32×32 | 24×24 viewBox | Feature icons, empty states |

### Size Rules

- **`sm` (16px):** Use only inline with `text-sm` or `text-xs` text. Never standalone.
- **`md` (20px):** Default size for buttons, inputs, navigation items.
- **`lg` (24px):** Use in cards, list items, or when icon needs visual weight.
- **`xl` (32px):** Use in empty states, onboarding, or hero sections. Maximum size.

---

## Icon Styles

Heroicons come in three styles. GsmUi uses them in specific contexts.

### Outline (Default)

Thin, stroke-based icons. The default style for most use cases.

```html
<!-- Heroicons outline: 24×24 viewBox, 1.5px stroke -->
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
</svg>
```

### Solid

Filled, solid icons. Use for active states, selected items, and emphasis.

```html
<!-- Heroicons solid: 24×24 viewBox, filled path -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
  <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
</svg>
```

### Mini

Smaller, more compact icons for tight spaces.

```html
<!-- Heroicons mini: 20×20 viewBox, filled path -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
</svg>
```

### Style Usage Matrix

| Context | Style | Reason |
|---|---|---|
| Button icons | Outline | Lightweight, pairs with text |
| Navigation active | Solid | Visual emphasis on active item |
| Input adornments | Outline | Subtle, non-distracting |
| Checkbox/radio | Solid (when checked) | Clear on/off state |
| Alert icons | Solid | High visibility |
| Empty state | Outline or Solid | Depends on visual weight needed |
| Table row actions | Outline | Consistent with button icons |
| Dropdown items | Outline | Subtle, secondary to text |

---

## Icon Components

### `<x-gsmui:icon>` — Generic Icon Component

```blade
{{-- Outline icon (default) --}}
<x-gsmui:icon name="heroicon-o-check-circle" size="md" />

{{-- Solid icon --}}
<x-gsmui:icon name="heroicon-s-check-circle" size="md" />

{{-- Mini icon --}}
<x-gsmui:icon name="heroicon-m-check-circle" size="sm" />

{{-- With custom color --}}
<x-gsmui:icon name="heroicon-o-check-circle" size="md" class="text-gsmui-success" />

{{-- Inline with text --}}
<span class="inline-flex items-center gap-2">
  <x-gsmui:icon name="heroicon-o-information-circle" size="sm" />
  <span>Information text</span>
</span>
```

### Icon Props

| Prop | Type | Default | Description |
|---|---|---|---|
| `name` | `string` | required | Heroicon name (e.g., `heroicon-o-check-circle`) |
| `size` | `string` | `md` | Icon size: `sm`, `md`, `lg`, `xl` |
| `class` | `string` | `''` | Additional CSS classes |

### Naming Convention

Heroicon names follow the pattern: `heroicon-{style}-{name}`

| Prefix | Style | ViewBox |
|---|---|---|
| `heroicon-o-` | Outline | 24×24 |
| `heroicon-s-` | Solid | 24×24 |
| `heroicon-m-` | Mini | 20×20 |

---

## Custom Icons

For icons not in Heroicons, create custom SVG icons following these rules.

### Custom Icon Requirements

1. **ViewBox must be 24×24** (or 20×20 for mini style).
2. **Use `currentColor`** for the fill/stroke color to inherit from CSS.
3. **Stroke width 1.5px** for outline style to match Heroicons.
4. **No hardcoded colors** — always use `currentColor`.
5. **Optimize SVGs** — remove unnecessary attributes, comments, and whitespace.

### Custom Icon Example

```html
<!-- Good: Custom icon matching Heroicons conventions -->
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z" />
</svg>

<!-- Bad: Hardcoded colors, wrong viewBox, no stroke -->
<svg viewBox="0 0 32 32">
  <path fill="#ff0000" d="..." />
</svg>
```

---

## Icon Usage Rules

### Do

- **Use icons to reinforce meaning**, not to decorate.
- **Keep icons consistent** — same style within a single context.
- **Provide text labels** alongside icons in navigation and buttons.
- **Use `aria-hidden="true"`** on decorative icons.
- **Use `aria-label`** on standalone icon buttons.

### Don't

- **Never use icons alone** without text for critical actions.
- **Never mix styles** (outline + solid) in the same row or group.
- **Never use icons larger than xl (32px)** in standard UI.
- **Never animate icons** without respecting `prefers-reduced-motion`.
- **Never use colored icons** for status unless supplemented with text.

---

## Icon Buttons

Icon buttons require special handling for accessibility.

```blade
{{-- Icon button with label --}}
<x-gsmui:button icon="heroicon-o-x-mark" aria-label="Close">
  <span class="sr-only">Close</span>
</x-gsmui:button>

{{-- Icon button without visible label --}}
<x-gsmui:button icon-only aria-label="Delete item">
  <x-gsmui:icon name="heroicon-o-trash" size="md" />
  <span class="sr-only">Delete</span>
</x-gsmui:button>
```

### Accessibility Rules

| Scenario | Requirement |
|---|---|
| Icon + visible text | `aria-hidden="true"` on icon |
| Icon only (button) | `aria-label` on button, icon gets `aria-hidden="true"` |
| Icon only (link) | `aria-label` on link, icon gets `aria-hidden="true"` |
| Decorative icon | `aria-hidden="true"`, `role="presentation"` |
| Status icon | `aria-label` describing status, icon gets `aria-hidden="true"` |

---

## Icon Sizing in Context

| Context | Icon Size | Text Size | Gap |
|---|---|---|---|
| Button (md) | `md` (20px) | `text-sm` | `space-2` (8px) |
| Button (sm) | `sm` (16px) | `text-xs` | `space-1_5` (6px) |
| Input prefix | `md` (20px) | `text-base` | `space-2` (8px) |
| Navigation item | `lg` (24px) | `text-sm` | `space-3` (12px) |
| Table cell | `md` (20px) | `text-sm` | `space-2` (8px) |
| Alert | `lg` (24px) | `text-sm` | `space-3` (12px) |
| Empty state | `xl` (32px) | `text-base` | `space-4` (16px) |
| Dropdown item | `md` (20px) | `text-sm` | `space-2` (8px) |
| Badge | `sm` (16px) | `text-xs` | `space-1` (4px) |

---

## Tailwind Integration

```html
<!-- Size classes -->
<i data-lucide="check" class="w-4 h-4"></i>  <!-- sm: 16px -->
<i data-lucide="check" class="w-5 h-5"></i>  <!-- md: 20px -->
<i data-lucide="check" class="w-6 h-6"></i>  <!-- lg: 24px -->
<i data-lucide="check" class="w-8 h-8"></i>  <!-- xl: 32px -->

<!-- Color classes (inherit from parent) -->
<span class="text-gsmui-text-primary">
  <i data-lucide="check" class="w-5 h-5"></i>
</span>

<!-- Explicit color -->
<i data-lucide="check-circle" class="w-5 h-5 text-gsmui-success"></i>
<i data-lucide="x-circle" class="w-5 h-5 text-gsmui-error"></i>
```

---

## Summary

| Aspect | Convention |
|---|---|
| Library | Heroicons (MIT) |
| Sizes | sm (16px), md (20px), lg (24px), xl (32px) |
| Styles | Outline (default), Solid, Mini |
| Naming | `heroicon-{style}-{name}` |
| Color | Always `currentColor`, never hardcoded |
| Accessibility | `aria-hidden` decorative, `aria-label` interactive |
| Custom icons | Follow Heroicons viewBox and stroke conventions |
