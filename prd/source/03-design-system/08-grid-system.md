# 08 — Grid System

> The responsive grid, breakpoint system, and layout conventions for GsmUi.

---

## Grid Philosophy

GsmUi's grid system is built on CSS Grid and Flexbox. It provides a predictable, responsive layout system that works across all viewport sizes without JavaScript.

### Core Principles

1. **Mobile-first.** Styles start at the smallest viewport and scale up.
2. **12-column grid.** The standard for web layouts.
3. **Fluid where possible.** Fixed containers at specific breakpoints, fluid gutters.
4. **No framework lock-in.** Pure CSS Grid + Tailwind utilities.

---

## Breakpoint System

GsmUi defines five breakpoints that map to common device widths.

| Breakpoint | Token | Min Width | Typical Device |
|---|---|---|---|
| `sm` | `--gsmui-breakpoint-sm` | 640px | Large phone landscape |
| `md` | `--gsmui-breakpoint-md` | 768px | Tablet portrait |
| `lg` | `--gsmui-breakpoint-lg` | 1024px | Tablet landscape / small desktop |
| `xl` | `--gsmui-breakpoint-xl` | 1280px | Desktop |
| `2xl` | `--gsmui-breakpoint-2xl` | 1536px | Large desktop |

### Breakpoint Usage

| Breakpoint | Columns | Gutter | Container Padding |
|---|---|---|---|
| Base (< 640px) | 4 | 16px | 16px |
| `sm` (640px+) | 8 | 16px | 24px |
| `md` (768px+) | 8 | 20px | 32px |
| `lg` (1024px+) | 12 | 24px | 48px |
| `xl` (1280px+) | 12 | 24px | 64px |
| `2xl` (1536px+) | 12 | 32px | 64px |

---

## Container Widths

| Breakpoint | Max Width | Padding (each side) | Content Width |
|---|---|---|---|
| Base | 100% | 16px | 100% - 32px |
| `sm` | 640px | 24px | 592px |
| `md` | 768px | 32px | 704px |
| `lg` | 1024px | 48px | 928px |
| `xl` | 1280px | 64px | 1152px |
| `2xl` | 1536px | 64px | 1408px |

### Container Component

```blade
{{-- Basic container --}}
<x-gsmui:container>
  Content here
</x-gsmui:container>

{{-- Narrow container (for reading content) --}}
<x-gsmui:container size="narrow">
  Long-form content here
</x-gsmui:container>

{{-- Wide container (for dashboards) --}}
<x-gsmui:container size="wide">
  Dashboard content here
</x-gsmui:container>
```

| Size | Max Width | Usage |
|---|---|---|
| `default` | 1280px | Standard page content |
| `narrow` | 768px | Articles, documentation, forms |
| `wide` | 1536px | Dashboards, data tables, admin panels |
| `full` | 100% | Full-bleed sections |

---

## 12-Column Grid

The 12-column grid divides the viewport into 12 equal columns with gutters between them.

### Column Span Examples

| Layout | Columns | Width |
|---|---|---|
| Full width | 12 | 100% |
| Two equal columns | 6 + 6 | 50% + 50% |
| Three equal columns | 4 + 4 + 4 | 33.3% each |
| Sidebar + content | 3 + 9 | 25% + 75% |
| Content + sidebar | 9 + 3 | 75% + 25% |
| Four equal columns | 3 + 3 + 3 + 3 | 25% each |
| Wide + narrow | 8 + 4 | 66.7% + 33.3% |

### Tailwind Grid Classes

```html
<!-- 12-column grid -->
<div class="grid grid-cols-12 gap-4">
  <div class="col-span-12">Full width</div>
</div>

<!-- Two equal columns -->
<div class="grid grid-cols-12 gap-4">
  <div class="col-span-6">Left</div>
  <div class="col-span-6">Right</div>
</div>

<!-- Sidebar layout -->
<div class="grid grid-cols-12 gap-4">
  <div class="col-span-12 lg:col-span-3">Sidebar</div>
  <div class="col-span-12 lg:col-span-9">Content</div>
</div>

<!-- Responsive: stack on mobile, 3 columns on desktop -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
  <div>Card 1</div>
  <div>Card 2</div>
  <div>Card 3</div>
</div>
```

---

## Gutters

Gutters are the spaces between grid columns and rows.

| Context | Gap | Tailwind |
|---|---|---|
| Tight (inline elements) | 4px | `gap-1` |
| Default (cards, list) | 16px | `gap-4` |
| Relaxed (sections) | 24px | `gap-6` |
| Loose (page sections) | 32px | `gap-8` |
| Spacious (hero areas) | 48px | `gap-12` |

### Row Gaps

| Context | Gap | Tailwind |
|---|---|---|
| Compact (table rows) | 1px | `gap-px` |
| Default (card grid) | 16px | `gap-y-4` |
| Relaxed (form fields) | 24px | `gap-y-6` |
| Spacious (page sections) | 64px | `gap-y-16` |

---

## Responsive Grid Patterns

### Sidebar + Content

```html
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
  <aside class="lg:col-span-1">
    <!-- Sidebar: 25% on desktop, full width on mobile -->
  </aside>
  <main class="lg:col-span-3">
    <!-- Content: 75% on desktop, full width on mobile -->
  </main>
</div>
```

### Dashboard Layout

```html
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
  <div class="sm:col-span-2 lg:col-span-1">Metric 1</div>
  <div class="sm:col-span-2 lg:col-span-1">Metric 2</div>
  <div class="sm:col-span-2 lg:col-span-1">Metric 3</div>
  <div class="sm:col-span-2 lg:col-span-1">Metric 4</div>
</div>
```

### Content + Sidebar (Reversed)

```html
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <main class="lg:col-span-2">
    <!-- Main content: 66.7% on desktop -->
  </main>
  <aside class="lg:col-span-1">
    <!-- Sidebar: 33.3% on desktop -->
  </aside>
</div>
```

### Holy Grail Layout

```html
<div class="min-h-screen grid grid-rows-[auto_1fr_auto]">
  <header class="col-span-full">Header</header>
  <div class="grid grid-cols-1 lg:grid-cols-[250px_1fr_250px] gap-6">
    <aside class="hidden lg:block">Left sidebar</aside>
    <main>Content</main>
    <aside class="hidden lg:block">Right sidebar</aside>
  </div>
  <footer class="col-span-full">Footer</footer>
</div>
```

---

## Layout Patterns

### Centered Content

```html
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
  Centered content with max-width
</div>
```

### Full Bleed

```html
<div class="w-full">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="-mx-4 sm:-mx-6 lg:-mx-8">
      Full bleed image or background
    </div>
  </div>
</div>
```

### Sticky Footer

```html
<div class="min-h-screen flex flex-col">
  <header>Header</header>
  <main class="flex-1">Content</main>
  <footer>Footer</footer>
</div>
```

---

## Grid Utilities

### CSS Grid Properties

```css
.gsmui-grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: var(--gsmui-space-4);
}

.gsmui-grid-col-3 { grid-column: span 3 / span 3; }
.gsmui-grid-col-4 { grid-column: span 4 / span 4; }
.gsmui-grid-col-6 { grid-column: span 6 / span 6; }
.gsmui-grid-col-8 { grid-column: span 8 / span 8; }
.gsmui-grid-col-9 { grid-column: span 9 / span 9; }
.gsmui-grid-col-12 { grid-column: span 12 / span 12; }
```

### Auto-Fit Grid

For card layouts that automatically adjust columns:

```html
<div class="grid grid-cols-[repeat(auto-fit,minmax(300px,1fr))] gap-4">
  <div>Card 1</div>
  <div>Card 2</div>
  <div>Card 3</div>
</div>
```

---

## Common Layout Templates

### Page Layout

```blade
<x-gsmui:container>
  <x-gsmui:heading level="1">Page Title</x-gsmui:heading>

  <div class="mt-8 grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
      {{-- Main content --}}
    </div>
    <div class="lg:col-span-1">
      {{-- Sidebar --}}
    </div>
  </div>
</x-gsmui:container>
```

### Form Layout

```blade
<x-gsmui:container size="narrow">
  <form class="space-y-6">
    <x-gsmui:input label="Name" wire:model="name" />
    <x-gsmui:input label="Email" wire:model="email" type="email" />
    <x-gsmui:textarea label="Message" wire:model="message" />
    <x-gsmui:button type="submit">Submit</x-gsmui:button>
  </form>
</x-gsmui:container>
```

### Card Grid

```blade
<x-gsmui:container>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($items as $item)
      <x-gsmui:card>
        <x-gsmui:card:header>
          {{ $item->title }}
        </x-gsmui:card:header>
        <x-gsmui:card:content>
          {{ $item->description }}
        </x-gsmui:card:content>
      </x-gsmui:card>
    @endforeach
  </div>
</x-gsmui:container>
```

---

## Grid Audit Checklist

1. **Mobile-first.** Base styles apply to mobile, breakpoints scale up.
2. **Consistent gutters.** Same context = same gap.
3. **No fixed widths.** Use grid columns, not pixel widths.
4. **Semantic wrappers.** Use `<main>`, `<aside>`, `<header>`, `<footer>`.
5. **Test at all breakpoints.** Verify layout at 320px, 640px, 768px, 1024px, 1280px, 1536px.

---

## Summary

| Concept | Convention |
|---|---|
| Grid | 12-column CSS Grid |
| Breakpoints | 5 (sm, md, lg, xl, 2xl) |
| Mobile-first | Base styles + min-width queries |
| Gutters | 16px–32px depending on context |
| Containers | 4 sizes (narrow, default, wide, full) |
| Approach | CSS Grid primary, Flexbox for single-axis |
