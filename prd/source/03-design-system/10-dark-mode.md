# 10 — Dark Mode

> The dark mode implementation, color strategy, and component adaptation rules for GsmUi.

---

## Dark Mode Philosophy

Dark mode in GsmUi is a first-class citizen, not a light mode inversion. Colors are carefully adjusted for dark environments, not simply negated.

### Core Principles

1. **Class-based toggling.** Use a `.dark` class on `<html>`, not media queries alone.
2. **Semantic tokens.** Components reference semantic tokens, never raw colors.
3. **Adjusted, not inverted.** Dark mode colors are tuned for OLED displays and reduced luminance.
4. **System preference detection.** Default to the user's OS setting, allow manual override.

---

## CSS Strategy

GsmUi uses class-based dark mode via Tailwind's `darkMode: 'class'` strategy.

### HTML Setup

```html
<html lang="en" class="dark">
  <!-- or -->
<html lang="en">
```

### Tailwind Configuration

```js
// tailwind.config.js
module.exports = {
  darkMode: 'class',
  // ...
}
```

### CSS Variable Overrides

```css
:root {
  /* Light mode defaults */
  --gsmui-bg-page: var(--gsmui-color-neutral-50);
  --gsmui-bg-surface: #ffffff;
  --gsmui-bg-surface-raised: #ffffff;
  --gsmui-bg-sunken: var(--gsmui-color-neutral-100);
  --gsmui-text-primary: var(--gsmui-color-neutral-900);
  --gsmui-text-secondary: var(--gsmui-color-neutral-500);
  --gsmui-text-tertiary: var(--gsmui-color-neutral-400);
  --gsmui-text-disabled: var(--gsmui-color-neutral-300);
  --gsmui-text-inverse: #ffffff;
  --gsmui-border-default: var(--gsmui-color-neutral-200);
  --gsmui-border-strong: var(--gsmui-color-neutral-300);
  --gsmui-border-subtle: var(--gsmui-color-neutral-100);
  --gsmui-action-primary: var(--gsmui-color-blue-600);
  --gsmui-action-primary-hover: var(--gsmui-color-blue-700);
  --gsmui-action-primary-active: var(--gsmui-color-blue-800);
  --gsmui-action-danger: var(--gsmui-color-error-600);
  --gsmui-action-danger-hover: var(--gsmui-color-error-700);
  --gsmui-focus-ring: var(--gsmui-color-blue-500);
  --gsmui-focus-ring-offset: #ffffff;
  --gsmui-shadow-color: 0deg 0% 0%;
}

.dark {
  /* Dark mode overrides */
  --gsmui-bg-page: #0a0a0b;
  --gsmui-bg-surface: var(--gsmui-color-neutral-800);
  --gsmui-bg-surface-raised: var(--gsmui-color-neutral-700);
  --gsmui-bg-sunken: #000000;
  --gsmui-text-primary: var(--gsmui-color-neutral-50);
  --gsmui-text-secondary: var(--gsmui-color-neutral-400);
  --gsmui-text-tertiary: var(--gsmui-color-neutral-500);
  --gsmui-text-disabled: var(--gsmui-color-neutral-600);
  --gsmui-text-inverse: var(--gsmui-color-neutral-900);
  --gsmui-border-default: var(--gsmui-color-neutral-700);
  --gsmui-border-strong: var(--gsmui-color-neutral-600);
  --gsmui-border-subtle: var(--gsmui-color-neutral-800);
  --gsmui-action-primary: var(--gsmui-color-blue-500);
  --gsmui-action-primary-hover: var(--gsmui-color-blue-400);
  --gsmui-action-primary-active: var(--gsmui-color-blue-300);
  --gsmui-action-danger: var(--gsmui-color-error-500);
  --gsmui-action-danger-hover: var(--gsmui-color-error-400);
  --gsmui-focus-ring: var(--gsmui-color-blue-400);
  --gsmui-focus-ring-offset: var(--gsmui-color-neutral-900);
  --gsmui-shadow-color: 0deg 0% 0%;
}
```

---

## Color Adjustments

### Background Colors

| Token | Light Mode | Dark Mode | Purpose |
|---|---|---|---|
| `--gsmui-bg-page` | Neutral-50 (#f9fafb) | #0a0a0b | Page background |
| `--gsmui-bg-surface` | White (#ffffff) | Neutral-800 (#1f2937) | Card, popover backgrounds |
| `--gsmui-bg-surface-raised` | White (#ffffff) | Neutral-700 (#374151) | Elevated surfaces |
| `--gsmui-bg-sunken` | Neutral-100 (#f3f4f6) | Black (#000000) | Recessed areas |

### Text Colors

| Token | Light Mode | Dark Mode | Purpose |
|---|---|---|---|
| `--gsmui-text-primary` | Neutral-900 (#111827) | Neutral-50 (#f9fafb) | Headings, body text |
| `--gsmui-text-secondary` | Neutral-500 (#6b7280) | Neutral-400 (#9ca3af) | Captions, helper text |
| `--gsmui-text-tertiary` | Neutral-400 (#9ca3af) | Neutral-500 (#6b7280) | Placeholder text |
| `--gsmui-text-disabled` | Neutral-300 (#d1d5db) | Neutral-600 (#4b5563) | Disabled text |
| `--gsmui-text-inverse` | White (#ffffff) | Neutral-900 (#111827) | Text on colored backgrounds |

### Border Colors

| Token | Light Mode | Dark Mode | Purpose |
|---|---|---|---|
| `--gsmui-border-default` | Neutral-200 (#e5e7eb) | Neutral-700 (#374151) | Default borders |
| `--gsmui-border-strong` | Neutral-300 (#d1d5db) | Neutral-600 (#4b5563) | Emphasized borders |
| `--gsmui-border-subtle` | Neutral-100 (#f3f4f6) | Neutral-800 (#1f2937) | Subtle dividers |

### Action Colors

| Token | Light Mode | Dark Mode | Purpose |
|---|---|---|---|
| `--gsmui-action-primary` | Blue-600 (#2563eb) | Blue-500 (#3b82f6) | Primary actions |
| `--gsmui-action-primary-hover` | Blue-700 (#1d4ed8) | Blue-400 (#60a5fa) | Hover state |
| `--gsmui-action-primary-active` | Blue-800 (#1e40af) | Blue-300 (#93c5fd) | Active/pressed state |

### Shadow Colors

| Token | Light Mode | Dark Mode |
|---|---|---|
| `--gsmui-shadow-color` | `0deg 0% 0%` | `0deg 0% 0%` |
| Shadow opacity | 10% | 30% |

Dark mode uses the same shadow color but with higher opacity to remain visible against dark backgrounds.

---

## Component Adaptations

### Button

| Property | Light Mode | Dark Mode |
|---|---|---|
| Primary background | Blue-600 | Blue-500 |
| Primary text | White | White |
| Primary hover | Blue-700 | Blue-400 |
| Secondary background | White | Neutral-700 |
| Secondary text | Neutral-900 | Neutral-50 |
| Secondary border | Neutral-200 | Neutral-600 |
| Disabled background | Neutral-100 | Neutral-700 |
| Disabled text | Neutral-300 | Neutral-600 |

### Input

| Property | Light Mode | Dark Mode |
|---|---|---|
| Background | White | Neutral-800 |
| Border | Neutral-200 | Neutral-600 |
| Text | Neutral-900 | Neutral-50 |
| Placeholder | Neutral-400 | Neutral-500 |
| Focus ring | Blue-500 | Blue-400 |
| Disabled bg | Neutral-50 | Neutral-800 |

### Card

| Property | Light Mode | Dark Mode |
|---|---|---|
| Background | White | Neutral-800 |
| Border | Neutral-200 | Neutral-700 |
| Shadow | 10% opacity | 30% opacity |

### Popover / Dropdown

| Property | Light Mode | Dark Mode |
|---|---|---|
| Background | White | Neutral-700 |
| Border | Neutral-200 | Neutral-600 |
| Shadow | Standard | Increased opacity |
| Arrow | White | Neutral-700 |

### Dialog / Modal

| Property | Light Mode | Dark Mode |
|---|---|---|
| Overlay | Black 50% | Black 70% |
| Background | White | Neutral-800 |
| Border | Neutral-200 | Neutral-700 |

### Table

| Property | Light Mode | Dark Mode |
|---|---|---|
| Header bg | Neutral-50 | Neutral-800 |
| Row hover | Neutral-50 | Neutral-700 |
| Border | Neutral-200 | Neutral-700 |
| Striped row | Neutral-50/White | Neutral-800/Neutral-700 |

### Alert

| Variant | Light Background | Dark Background | Light Border | Dark Border |
|---|---|---|---|---|
| Success | Success-50 | Success-900/20 | Success-200 | Success-800/30 |
| Warning | Warning-50 | Warning-900/20 | Warning-200 | Warning-800/30 |
| Error | Error-50 | Error-900/20 | Error-200 | Error-800/30 |
| Info | Info-50 | Info-900/20 | Info-200 | Info-800/30 |

---

## Toggle Mechanism

### PHP / Blade

```blade
{{-- Dark mode toggle button --}}
<x-gsmui:button
  wire:click="toggleDarkMode"
  icon="heroicon-o-moon"
  aria-label="Toggle dark mode"
/>

{{-- Or using Alpine.js --}}
<button
  x-data="{ dark: $persist(localStorage.getItem('darkMode') === 'true') }"
  x-init="$watch('dark', val => {
    document.documentElement.classList.toggle('dark', val);
    localStorage.setItem('darkMode', val);
  })"
  @click="dark = !dark"
  :aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'"
>
  <x-gsmui:icon :name="dark ? 'heroicon-o-sun' : 'heroicon-o-moon'" size="md" />
</button>
```

### JavaScript

```js
// Dark mode manager
const DarkMode = {
  init() {
    const stored = localStorage.getItem('darkMode');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDark = stored !== null ? stored === 'true' : prefersDark;

    this.set(isDark);

    // Listen for OS preference changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      if (localStorage.getItem('darkMode') === null) {
        this.set(e.matches);
      }
    });
  },

  toggle() {
    this.set(!document.documentElement.classList.contains('dark'));
  },

  set(dark) {
    document.documentElement.classList.toggle('dark', dark);
    localStorage.setItem('darkMode', dark);

    // Dispatch event for components that need to react
    window.dispatchEvent(new CustomEvent('darkmodechange', { detail: { dark } }));
  },

  isDark() {
    return document.documentElement.classList.contains('dark');
  },
};

DarkMode.init();
```

---

## System Preference Detection

### CSS Media Query (Fallback)

```css
/* Respect system preference if no manual override */
@media (prefers-color-scheme: dark) {
  :root:not(.light) {
    /* Apply dark mode variables */
  }
}
```

### Detection Priority

1. **Manual override** (localStorage) — highest priority
2. **System preference** (prefers-color-scheme) — default if no manual setting
3. **Light mode** — fallback if neither is available

### Implementation

```js
function getInitialDarkMode() {
  // 1. Check for manual override
  const stored = localStorage.getItem('darkMode');
  if (stored !== null) {
    return stored === 'true';
  }

  // 2. Check system preference
  if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    return true;
  }

  // 3. Default to light
  return false;
}
```

---

## Dark Mode in Tailwind

### Using Dark Prefix

```html
<!-- Background -->
<div class="bg-white dark:bg-neutral-800">Surface</div>

<!-- Text -->
<span class="text-neutral-900 dark:text-neutral-50">Primary text</span>

<!-- Border -->
<div class="border border-neutral-200 dark:border-neutral-700">Bordered</div>

<!-- Shadow -->
<div class="shadow-sm dark:shadow-neutral-900/30">Shadowed</div>
```

### Semantic Token Pattern (Preferred)

```html
<!-- Use semantic tokens instead of dark: prefix -->
<div class="bg-gsmui-bg-surface text-gsmui-text-primary border-gsmui-border-default">
  This automatically adapts to dark mode via CSS variables.
</div>
```

**Rule:** Prefer semantic tokens over `dark:` prefix. Use `dark:` only for one-off overrides not covered by the token system.

---

## Dark Mode Testing

### Manual Testing Checklist

1. **Toggle works.** Switch between light and dark mode.
2. **Persistence.** Refresh the page, mode persists.
3. **System preference.** Remove manual override, system preference is used.
4. **All components.** Every component looks correct in both modes.
5. **Contrast.** All text meets WCAG AA contrast in dark mode.
6. **Shadows.** Shadows are visible in dark mode.
7. **Focus rings.** Focus indicators are visible in dark mode.
8. **Images.** Images don't clash with dark backgrounds.
9. **Overlays.** Modal/drawer overlays are visible.

### Automated Testing

```js
// Test that dark mode class toggles correctly
test('dark mode toggle', () => {
  const html = document.documentElement;

  DarkMode.set(true);
  expect(html.classList.contains('dark')).toBe(true);

  DarkMode.set(false);
  expect(html.classList.contains('dark')).toBe(false);
});

// Test that CSS variables change
test('dark mode variables', () => {
  DarkMode.set(true);

  const bgSurface = getComputedStyle(document.documentElement)
    .getPropertyValue('--gsmui-bg-surface');

  expect(bgSurface).toBe('#1f2937'); // Neutral-800
});
```

---

## Common Dark Mode Issues

| Issue | Cause | Fix |
|---|---|---|
| Text invisible | Wrong color token | Use `--gsmui-text-primary` |
| Borders invisible | Missing dark border | Use `--gsmui-border-default` |
| Shadows invisible | Low opacity | Increase opacity in dark mode |
| Focus ring invisible | Wrong focus color | Use `--gsmui-focus-ring` |
| Images too bright | No dark filter | Add `dark:brightness-90` |
| Blue too bright | Same blue in both modes | Use Blue-500 in dark, Blue-600 in light |
| White backgrounds | Hard-coded white | Use `--gsmui-bg-surface` |
| Placeholder text invisible | Wrong neutral | Use `--gsmui-text-tertiary` |

---

## Summary

| Concept | Convention |
|---|---|
| Strategy | Class-based (`.dark` on `<html>`) |
| Tokens | Semantic tokens auto-switch |
| Colors | Adjusted, not inverted |
| Shadows | Increased opacity in dark |
| Toggle | Manual override + system preference |
| Persistence | localStorage |
| Testing | Manual + automated every release |

Dark mode is not a theme. It is a core product requirement.
