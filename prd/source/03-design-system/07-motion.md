# 07 — Motion

> The animation system, timing curves, and transition conventions for GsmUi.

---

## Motion Philosophy

Motion in GsmUi serves three purposes:

1. **Orient** — help users understand spatial relationships and navigation.
2. **Focus** — draw attention to important changes.
3. **Delight** — make interactions feel polished and responsive.

Motion is never gratuitous. Every animation must have a functional purpose.

---

## Duration Scale

GsmUi defines seven duration tokens. Each maps to a specific use case.

| Token | Value | Usage |
|---|---|---|
| `--gsmui-duration-75` | 75ms | Micro-interactions: checkbox toggle, icon spin |
| `--gsmui-duration-100` | 100ms | Hover states, focus transitions |
| `--gsmui-duration-150` | 150ms | Button press, input focus |
| `--gsmui-duration-200` | 200ms | Default transition, dropdown open |
| `--gsmui-duration-300` | 300ms | Popover/modal open, slide transitions |
| `--gsmui-duration-500` | 500ms | Complex animations, page transitions |
| `--gsmui-duration-700` | 700ms | Slow reveals, staggered animations |

### Duration Rules

- **Default is 200ms.** If unsure, use `duration-200`.
- **Never exceed 500ms** for UI animations. 700ms only for page-level transitions.
- **Never go below 75ms.** Anything faster is imperceptible.
- **Match duration to distance.** Short movements = short duration. Long movements = longer duration.

---

## Easing Curves

Easing curves control the acceleration and deceleration of animations.

| Token | Value | Curve | Usage |
|---|---|---|---|
| `--gsmui-ease-default` | `cubic-bezier(0.4, 0, 0.2, 1)` | Ease out | Default for most transitions |
| `--gsmui-ease-in` | `cubic-bezier(0.4, 0, 1, 1)` | Ease in | Exiting elements |
| `--gsmui-ease-out` | `cubic-bezier(0, 0, 0.2, 1)` | Ease out | Entering elements |
| `--gsmui-ease-in-out` | `cubic-bezier(0.4, 0, 0.2, 1)` | Ease in-out | Elements that move and change size |
| `--gsmui-ease-spring` | `cubic-bezier(0.34, 1.56, 0.64, 1)` | Spring | Playful micro-interactions |
| `--gsmui-ease-linear` | `linear` | Linear | Continuous animations, progress bars |

### Easing Rules

- **Entering elements** use `ease-out` — they decelerate as they arrive.
- **Exiting elements** use `ease-in` — they accelerate as they leave.
- **Moving elements** use `ease-in-out` — smooth acceleration and deceleration.
- **Spring curve** is reserved for playful moments — toggles, celebrations, bouncy feedback.
- **Linear** is only for progress bars, spinners, and continuous motion.

---

## Transition Utilities

Gsmui provides pre-built transition classes that map to tokens.

### CSS Transition Classes

```css
/* Base transition */
.gsmui-transition {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: var(--gsmui-ease-default);
  transition-duration: var(--gsmui-duration-200);
}

/* Duration variants */
.gsmui-transition-75 { transition-duration: var(--gsmui-duration-75); }
.gsmui-transition-100 { transition-duration: var(--gsmui-duration-100); }
.gsmui-transition-150 { transition-duration: var(--gsmui-duration-150); }
.gsmui-transition-200 { transition-duration: var(--gsmui-duration-200); }
.gsmui-transition-300 { transition-duration: var(--gsmui-duration-300); }
.gsmui-transition-500 { transition-duration: var(--gsmui-duration-500); }

/* Easing variants */
.gsmui-ease-default { transition-timing-function: var(--gsmui-ease-default); }
.gsmui-ease-in { transition-timing-function: var(--gsmui-ease-in); }
.gsmui-ease-out { transition-timing-function: var(--gsmui-ease-out); }
.gsmui-ease-in-out { transition-timing-function: var(--gsmui-ease-in-out); }
.gsmui-ease-spring { transition-timing-function: var(--gsmui-ease-spring); }
```

### Tailwind Transition Classes

```html
<!-- Default transition -->
<button class="transition-all duration-200 ease-in-out">Click me</button>

<!-- Color transition -->
<div class="transition-colors duration-150">Hover me</div>

<!-- Transform transition -->
<div class="transition-transform duration-200 ease-out hover:scale-105">Scale me</div>

<!-- Shadow transition -->
<div class="transition-shadow duration-200 hover:shadow-lg">Elevate me</div>

<!-- Opacity transition -->
<div class="transition-opacity duration-300">Fade me</div>
```

---

## Component Animations

### Popover / Dropdown

| Phase | Property | Duration | Easing |
|---|---|---|---|
| Open | `opacity`, `transform` | 200ms | `ease-out` |
| Close | `opacity`, `transform` | 150ms | `ease-in` |
| Arrow | `opacity` | 150ms | `ease-in-out` |

```css
/* Popover enter */
@keyframes gsmui-popover-enter {
  from {
    opacity: 0;
    transform: scale(0.95) translateY(-4px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

/* Popover exit */
@keyframes gsmui-popover-exit {
  from {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
  to {
    opacity: 0;
    transform: scale(0.95) translateY(-4px);
  }
}
```

### Dialog / Modal

| Phase | Property | Duration | Easing |
|---|---|---|---|
| Overlay enter | `opacity` | 200ms | `ease-out` |
| Content enter | `opacity`, `transform` | 200ms | `ease-spring` |
| Overlay exit | `opacity` | 150ms | `ease-in` |
| Content exit | `opacity`, `transform` | 150ms | `ease-in` |

```css
/* Dialog enter */
@keyframes gsmui-dialog-enter {
  from {
    opacity: 0;
    transform: scale(0.95) translateY(8px);
  }
  to {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}
```

### Drawer / Sheet

| Phase | Property | Duration | Easing |
|---|---|---|---|
| Open (right) | `transform` (translateX) | 300ms | `ease-out` |
| Open (left) | `transform` (translateX) | 300ms | `ease-out` |
| Open (top) | `transform` (translateY) | 300ms | `ease-out` |
| Open (bottom) | `transform` (translateY) | 300ms | `ease-out` |
| Close | `transform` | 200ms | `ease-in` |
| Overlay | `opacity` | 200ms | `ease-in-out` |

### Toast / Notification

| Phase | Property | Duration | Easing |
|---|---|---|---|
| Enter | `opacity`, `transform` | 300ms | `ease-spring` |
| Exit | `opacity`, `transform` | 200ms | `ease-in` |
| Auto-dismiss | — | 5000ms | — |

```css
/* Toast enter from right */
@keyframes gsmui-toast-enter {
  from {
    opacity: 0;
    transform: translateX(100%);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
```

### Tab Panel

| Phase | Property | Duration | Easing |
|---|---|---|---|
| Enter | `opacity`, `transform` | 200ms | `ease-out` |
| Exit | `opacity`, `transform` | 150ms | `ease-in` |

### Accordion

| Phase | Property | Duration | Easing |
|---|---|---|---|
| Expand | `height`, `opacity` | 200ms | `ease-in-out` |
| Collapse | `height`, `opacity` | 150ms | `ease-in-out` |

---

## Micro-Interactions

### Checkbox Toggle

```css
@keyframes gsmui-checkbox-check {
  0% { stroke-dashoffset: 24; }
  100% { stroke-dashoffset: 0; }
}

.gsmui-checkbox-icon {
  animation: gsmui-checkbox-check 200ms var(--gsmui-ease-out) forwards;
}
```

### Button Press

```css
.gsmui-button:active {
  transform: scale(0.98);
  transition: transform 75ms var(--gsmui-ease-in);
}
```

### Focus Ring

```css
.gsmui-focus-ring {
  transition: box-shadow 150ms var(--gsmui-ease-default);
}
```

### Spinner

```css
@keyframes gsmui-spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.gsmui-spinner {
  animation: gsmui-spin 700ms linear infinite;
}
```

### Skeleton Loading

```css
@keyframes gsmui-skeleton-pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.5; }
}

.gsmui-skeleton {
  animation: gsmui-skeleton-pulse 2000ms cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
```

---

## Reduced Motion

All animations must respect the user's motion preferences.

### CSS Query

```css
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
    scroll-behavior: auto !important;
  }
}
```

### JavaScript Check

```js
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (prefersReducedMotion) {
  // Skip animation, apply final state immediately
} else {
  // Run animation
}
```

### Component Behavior with Reduced Motion

| Component | Normal | Reduced Motion |
|---|---|---|
| Popover | Scale + fade in | Fade in only (no scale) |
| Dialog | Scale + fade in | Fade in only (no scale) |
| Drawer | Slide + fade in | Fade in only (no slide) |
| Toast | Slide from edge | Fade in (no slide) |
| Accordion | Height animation | Instant expand/collapse |
| Checkbox | Stroke animation | Instant check |
| Spinner | Rotation | Static icon |
| Skeleton | Pulse | Static placeholder |

---

## Animation Implementation Patterns

### CSS-Only Animations

For simple transitions, prefer CSS-only solutions:

```css
.gsmui-dropdown-menu {
  opacity: 0;
  transform: translateY(-4px) scale(0.95);
  transition: opacity 150ms var(--gsmui-ease-out), transform 150ms var(--gsmui-ease-out);
}

.gsmui-dropdown-menu[data-open="true"] {
  opacity: 1;
  transform: translateY(0) scale(1);
}
```

### JavaScript-Driven Animations

For complex sequences or interactive animations, use the Web Animations API:

```js
element.animate(
  [
    { opacity: 0, transform: 'translateY(-4px) scale(0.95)' },
    { opacity: 1, transform: 'translateY(0) scale(1)' },
  ],
  {
    duration: 200,
    easing: 'cubic-bezier(0, 0, 0.2, 1)',
    fill: 'forwards',
  }
);
```

---

## Motion Audit Checklist

When reviewing component animations, verify:

1. **Every animation has a purpose.** Remove decorative motion.
2. **Durations are from the scale.** No arbitrary values.
3. **Easing curves are appropriate.** Ease-out for enter, ease-in for exit.
4. **Reduced motion is respected.** Test with the OS preference enabled.
5. **No jank.** Animations use `transform` and `opacity` only — no layout-triggering properties.
6. **Performance.** No animations on `width`, `height`, `top`, `left`, `margin`, or `padding`.

---

## Summary

| Concept | Convention |
|---|---|
| Default duration | 200ms |
| Max duration | 500ms (700ms for page transitions) |
| Default easing | `ease-out` for enter, `ease-in` for exit |
| Spring curve | Playful micro-interactions only |
| Reduced motion | Always respected, CSS + JS |
| Animated properties | `transform` and `opacity` only |
| Performance | No layout-triggering properties |

Motion is the punctuation of design. Use it deliberately.
