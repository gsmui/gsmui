# 01 — Design Principles

> The foundational values that guide every decision in the GsmUi design system.

---

## 1. Consistency

Users should never have to re-learn how to interact with your product. Consistency means that similar elements look and behave the same way across every page and every component.

### Visual Consistency

- **Color usage** follows strict rules. Primary actions are always blue. Destructive actions are always red. Feedback is always green (success), yellow (warning), or red (error).
- **Typography hierarchy** is fixed. There is exactly one `h1` size, one `body` size, one `caption` size — not five.
- **Spacing** comes from a single scale. Elements are never arbitrarily spaced.

### Behavioral Consistency

- Clicking a trigger opens a popover. Every time.
- Pressing Escape closes the nearest popover. Every time.
- Tab order follows DOM order. No exceptions.

```css
/* Good: Consistent token usage */
.card {
  padding: var(--gsmui-space-4);
  border-radius: var(--gsmui-radius-lg);
  background: var(--gsmui-bg-surface);
}

/* Bad: Hard-coded values */
.card {
  padding: 16px;
  border-radius: 8px;
  background: white;
}
```

---

## 2. Accessibility

Accessibility is not a feature — it is a requirement. Every component in GsmUi must meet WCAG 2.1 AA conformance as a baseline.

### Core Requirements

| Requirement | Target | Standard |
|---|---|---|
| Color contrast | ≥ 4.5:1 normal text | WCAG AA |
| Color contrast | ≥ 3:1 large text | WCAG AA |
| Color contrast | ≥ 3:1 UI components | WCAG AA |
| Focus visibility | Visible focus ring on all interactive elements | WCAG 2.4.7 |
| Keyboard navigation | All functionality accessible via keyboard | WCAG 2.1.1 |
| Screen reader | Meaningful labels and roles on all components | WCAG 4.1.2 |

### Non-Negotiable Rules

1. No component ships without keyboard support.
2. No color-only communication — icons, text, or patterns supplement color.
3. No focus traps except in modals and dialogs.
4. All animations respect `prefers-reduced-motion`.

---

## 3. Performance

Performance is a feature. Slow components are broken components.

### Performance Budgets

| Metric | Budget |
|---|---|
| JavaScript bundle (per component) | < 5 KB gzipped |
| CSS (per component) | < 2 KB gzipped |
| First paint (with GsmUi loaded) | < 50ms |
| Time to interactive | < 100ms |

### Rules

- **Lazy load by default.** Popovers, dialogs, and drawers render their content on first open, not on page load.
- **No layout shifts.** Every component has reserved space before content loads.
- **Minimal DOM.** If an element does not contribute to semantics or behavior, remove it.
- **CSS over JS.** Prefer `transition` and `animation` properties over JavaScript-based animation where possible.
- **Tree-shakeable.** Import only the components you use, not the entire library.

---

## 4. Developer Experience

A design system that developers hate will not be adopted. GsmUi must be a pleasure to use.

### API Design Principles

- **Predictable naming.** If you know one component's API, you can guess another's.
- **Sensible defaults.** A component should work correctly with zero configuration.
- **Progressive complexity.** Simple things are simple; complex things are possible.
- **Type safety.** Full TypeScript support with auto-complete and compile-time checks.

### Example: Predictable API

```blade
{{-- Every component follows the same pattern --}}
<x-gsmui:button size="md" variant="primary">Save</x-gsmui:button>
<x-gsmui:select size="md" placeholder="Choose...">...</x-gsmui:select>
<x-gsmui:date-picker size="md" placeholder="Pick a date">...</x-gsmui:date-picker>
```

### Documentation

- Every prop is documented with type, default, and description.
- Every component has copy-pasteable examples.
- Every component shows its rendered output alongside its code.

---

## 5. Composability

Components should compose together without conflicts. A button inside a toolbar inside a popover should just work.

### Composition Rules

1. **No global state.** Components communicate via events and props, not shared singletons.
2. **Nested themes.** A dark-themed panel inside a light page works without hacks.
3. **Slot-based customization.** Use Blade slots for content injection, not configuration objects.
4. **Class merging.** Use `Gsmui::classes()` to merge user-provided classes with component defaults.

```blade
{{-- Composable: button group --}}
<x-gsmui:button-group>
  <x-gsmui:button>Left</x-gsmui:button>
  <x-gsmui:button>Middle</x-gsmui:button>
  <x-gsmui:button>Right</x-gsmui:button>
</x-gsmui:button-group>

{{-- Composable: input inside a popover --}}
<x-gsmui:popover>
  <x-gsmui:popover:trigger>
    <x-gsmui:button>Open</x-gsmui:button>
  </x-gsmui:popover:trigger>
  <x-gsmui:popover:content>
    <x-gsmui:input wire:model="search" placeholder="Search..." />
  </x-gsmui:popover:content>
</x-gsmui:popover>
```

---

## 6. Progressive Enhancement

The system works without JavaScript. JavaScript makes it better.

### Layered Architecture

| Layer | Technology | Purpose |
|---|---|---|
| Core | HTML + Blade | Structure, semantics, content |
| Style | Tailwind CSS + tokens | Visual appearance |
| Behavior | Livewire + JS | Interactivity, state management |
| Enhancement | JS mixins | Advanced interactions, animations |

### What This Means

- A `<gsmui:button>` renders a usable `<button>` element with no JavaScript.
- A `<gsmui:select>` falls back to a native `<select>` if JavaScript fails.
- Popovers and drawers are accessible without JavaScript via `<details>` elements or similar patterns.
- JavaScript enhances behavior — it is never required for basic functionality.

---

## 7. Design Tokens

Design tokens are the single source of truth for all visual decisions. They bridge design and code.

### Token Categories

| Category | Examples | Purpose |
|---|---|---|
| Color | `--gsmui-color-primary-500` | Brand and semantic colors |
| Typography | `--gsmui-text-lg`, `--gsmui-font-semibold` | Type scale and weights |
| Spacing | `--gsmui-space-4` | Consistent spacing |
| Border radius | `--gsmui-radius-lg` | Rounded corners |
| Shadows | `--gsmui-shadow-md` | Depth and elevation |
| Motion | `--gsmui-duration-200` | Animation timing |

### Token Hierarchy

```
Global tokens → Semantic tokens → Component tokens
(color-primary-500) → (color-action-primary) → (button-bg-primary)
```

Tokens must never be bypassed. Every visual value in the system must trace back to a token. If a value does not have a token, the token is missing and must be created.

---

## Summary

| Principle | One-Line Summary |
|---|---|
| Consistency | Same element, same behavior, everywhere |
| Accessibility | Works for everyone, by default |
| Performance | Fast is not optional |
| Developer Experience | A joy to use |
| Composability | Components play well together |
| Progressive Enhancement | Works without JS, better with it |
| Design Tokens | Single source of truth |

These principles are not aspirational — they are enforced. Every PR, every component, every decision is measured against them.
