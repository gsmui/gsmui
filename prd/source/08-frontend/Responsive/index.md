# Responsive Design

> Mobile-first, breakpoint system, container queries, fluid typography, touch targets.

## Mobile-First Approach

```blade
{{-- Start with mobile styles, add larger breakpoints --}}
<div class="p-4 sm:p-6 md:p-8 lg:p-10">
    {{ $slot }}
</div>

{{-- Mobile: stack, desktop: grid --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex-1">
        <h1 class="text-xl font-bold sm:text-2xl lg:text-3xl">Title</h1>
    </div>
    <div class="flex gap-2">
        <x-gsmui::button size="sm" class="sm:hidden">Mobile Action</x-gsmui::button>
        <x-gsmui::button size="md" class="hidden sm:inline-flex">Desktop Action</x-gsmui::button>
    </div>
</div>
```

## Breakpoint System

```css
/* Custom breakpoints in tailwind.config.js */
export default {
    theme: {
        screens: {
            'xs': '475px',
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
        },
    },
};
```

```blade
{{-- Responsive visibility --}}
<div class="hidden sm:block md:hidden lg:block">
    Visible on sm and lg, hidden on md
</div>

{{-- Responsive text --}}
<p class="text-sm md:text-base lg:text-lg">
    Responsive text size
</p>

{{-- Responsive spacing --}}
<div class="space-y-2 md:space-y-4 lg:space-y-6">
    <div>Item 1</div>
    <div>Item 2</div>
</div>
```

## Container Queries

```css
/* resources/css/components.css */
.card-container {
    container-type: inline-size;
    container-name: card;
}

@container card (min-width: 400px) {
    .card-layout {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 1rem;
    }
}

@container card (min-width: 600px) {
    .card-layout {
        grid-template-columns: 300px 1fr;
    }

    .card-title {
        font-size: 1.5rem;
    }
}
```

```blade
{{-- Container query usage --}}
<div class="card-container">
    <div class="card-layout">
        <div class="card-image">
            <img src="{{ $product->image }}" alt="{{ $product->name }}">
        </div>
        <div class="card-content">
            <h3 class="card-title text-lg font-semibold">{{ $product->name }}</h3>
            <p class="text-sm text-zinc-500">{{ $product->description }}</p>
        </div>
    </div>
</div>
```

## Fluid Typography

```css
/* resources/css/typography.css */
:root {
    --step--2: clamp(0.69rem, 0.66rem + 0.18vw, 0.80rem);
    --step--1: clamp(0.83rem, 0.78rem + 0.29vw, 1.00rem);
    --step-0: clamp(1.00rem, 0.91rem + 0.43vw, 1.25rem);
    --step-1: clamp(1.20rem, 1.07rem + 0.63vw, 1.56rem);
    --step-2: clamp(1.44rem, 1.26rem + 0.89vw, 1.95rem);
    --step-3: clamp(1.73rem, 1.48rem + 1.24vw, 2.44rem);
    --step-4: clamp(2.07rem, 1.73rem + 1.70vw, 3.05rem);
}

h1 { font-size: var(--step-4); }
h2 { font-size: var(--step-3); }
h3 { font-size: var(--step-2); }
h4 { font-size: var(--step-1); }
body { font-size: var(--step-0); }
small { font-size: var(--step--1); }
```

```blade
{{-- Fluid typography usage --}}
<h1 class="text-[var(--step-4)] font-bold">Page Title</h1>
<h2 class="text-[var(--step-3)] font-semibold">Section Title</h2>
<p class="text-[var(--step-0)]">Body text</p>
```

## Touch Targets

```css
/* Minimum touch target size: 44x44px */
.touch-target {
    min-width: 44px;
    min-height: 44px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Button variants with proper touch targets */
.button-sm { min-height: 32px; padding: 4px 12px; }
.button-md { min-height: 40px; padding: 8px 16px; }
.button-lg { min-height: 48px; padding: 12px 24px; }
```

```blade
{{-- Touch-friendly button --}}
<button class="min-h-[44px] min-w-[44px] rounded-lg bg-blue-600 px-4 py-2 text-white">
    Click me
</button>

{{-- Touch-friendly link --}}
<a href="#" class="flex min-h-[44px] items-center px-3 py-2 text-blue-600 hover:underline">
    Link text
</a>
```

## Responsive Grid

```blade
{{-- Auto-responsive grid --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    @foreach($items as $item)
        <div class="rounded-lg border border-zinc-200 p-4">
            {{ $item->name }}
        </div>
    @endforeach
</div>

{{-- Grid with column span --}}
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
    <div class="md:col-span-2">
        Main content
    </div>
    <div class="md:col-span-1">
        Sidebar
    </div>
</div>
```

## Responsive Images

```blade
{{-- Responsive image --}}
<img
    src="{{ $product->image }}"
    alt="{{ $product->name }}"
    class="h-auto w-full max-w-full"
    loading="lazy"
    decoding="async"
/>

{{-- Responsive image with aspect ratio --}}
<div class="aspect-video overflow-hidden rounded-lg">
    <img
        src="{{ $product->image }}"
        alt="{{ $product->name }}"
        class="h-full w-full object-cover"
        loading="lazy"
    />
</div>
```

## Mobile Navigation

```blade
{{-- Mobile menu --}}
<div x-data="{ open: false }">
    {{-- Mobile hamburger --}}
    <button @click="open = !open" class="lg:hidden">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    {{-- Mobile menu panel --}}
    <div x-show="open" x-transition
         class="fixed inset-0 z-50 bg-white dark:bg-zinc-900 lg:hidden">
        <div class="flex h-16 items-center justify-between border-b border-zinc-200 px-4">
            <span class="text-lg font-semibold">Menu</span>
            <button @click="open = false">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="p-4">
            {{-- Mobile navigation items --}}
        </nav>
    </div>
</div>
```

## Responsive Testing Checklist

| Viewport | Width | Check |
|---|---|---|
| iPhone SE | 375px | Layout, text, touch targets |
| iPhone 14 | 390px | Layout, text, touch targets |
| iPad | 768px | Tablet layout, navigation |
| iPad Pro | 1024px | Tablet landscape |
| Desktop | 1280px | Full layout |
| Large Desktop | 1536px | Max-width containers |
