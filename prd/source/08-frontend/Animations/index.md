# Animation System

> CSS transitions, Alpine.js animations, GSAP integration, reduced motion, performance.

## CSS Transitions

```css
/* resources/css/animations.css */
:root {
    --gsmui-duration-fast: 150ms;
    --gsmui-duration-normal: 200ms;
    --gsmui-duration-slow: 300ms;
    --gsmui-ease-in: cubic-bezier(0.4, 0, 1, 1);
    --gsmui-ease-out: cubic-bezier(0, 0, 0.2, 1);
    --gsmui-ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Base transition classes */
.transition-fast {
    transition-property: color, background-color, border-color, box-shadow, opacity;
    transition-duration: var(--gsmui-duration-fast);
    transition-timing-function: var(--gsmui-ease-in-out);
}

.transition-normal {
    transition-property: color, background-color, border-color, box-shadow, opacity;
    transition-duration: var(--gsmui-duration-normal);
    transition-timing-function: var(--gsmui-ease-in-out);
}

.transition-slow {
    transition-property: color, background-color, border-color, box-shadow, opacity;
    transition-duration: var(--gsmui-duration-slow);
    transition-timing-function: var(--gsmui-ease-in-out);
}

/* Transform transitions */
.transition-transform {
    transition-property: transform;
    transition-duration: var(--gsmui-duration-normal);
    transition-timing-function: var(--gsmui-ease-in-out);
}

/* Hover effects */
.hover-lift {
    transition: transform var(--gsmui-duration-fast) var(--gsmui-ease-out),
                box-shadow var(--gsmui-duration-fast) var(--gsmui-ease-out);
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}
```

## Alpine.js Animations

```blade
{{-- Fade in/out --}}
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        Content
    </div>
</div>

{{-- Slide in/out --}}
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-4 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-4 opacity-0">
        Content
    </div>
</div>

{{-- Scale --}}
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="scale-95 opacity-0"
         x-transition:enter-end="scale-100 opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="scale-100 opacity-100"
         x-transition:leave-end="scale-95 opacity-0">
        Content
    </div>
</div>
```

## GSAP Integration

```js
// resources/js/animations.js
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Fade in on scroll
export function initScrollAnimations() {
    gsap.utils.toArray('.animate-fade-in').forEach(element => {
        gsap.from(element, {
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: element,
                start: 'top 80%',
                toggleActions: 'play none none none',
            },
        });
    });
}

// Stagger children
export function initStaggerAnimations() {
    gsap.utils.toArray('.animate-stagger').forEach(container => {
        gsap.from(container.children, {
            opacity: 0,
            y: 20,
            duration: 0.5,
            stagger: 0.1,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: container,
                start: 'top 80%',
            },
        });
    });
}

// Counter animation
export function animateCounter(element, target) {
    gsap.to(element, {
        innerText: target,
        duration: 2,
        snap: { innerText: 1 },
        ease: 'power1.inOut',
    });
}
```

## Reduced Motion

```css
/* Respect user preference */
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

/* Disable specific animations */
.no-motion * {
    animation: none !important;
    transition: none !important;
}
```

```blade
{{-- Respect reduced motion preference --}}
<div x-data="{ prefersReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches }"
     @if="prefersReducedMotion" x-init="document.documentElement.classList.add('no-motion')">
</div>

{{-- Or via Alpine plugin --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.directive('motion', (el, { expression }) => {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        // Apply animation
    });
});
</script>
```

## Performance

```css
/* Use transform and opacity for GPU acceleration */
.gpu-accelerated {
    will-change: transform, opacity;
    transform: translateZ(0);
}

/* Avoid animating layout properties */
.bad-animation {
    /* DON'T animate these */
    width: 0;
    height: 0;
    margin: 0;
    padding: 0;
}

.good-animation {
    /* DO animate these */
    transform: scale(1);
    opacity: 1;
}
```

## Animation Patterns

```blade
{{-- Loading skeleton --}}
<div class="animate-pulse rounded bg-zinc-200 dark:bg-zinc-700">
    <div class="h-4 w-3/4 rounded bg-zinc-300 dark:bg-zinc-600"></div>
    <div class="mt-2 h-4 w-1/2 rounded bg-zinc-300 dark:bg-zinc-600"></div>
</div>

{{-- Spinner --}}
<div class="flex items-center justify-center">
    <svg class="h-8 w-8 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
</div>

{{-- Progress bar --}}
<div class="h-2 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-700">
    <div class="h-full bg-blue-600 transition-all duration-500 ease-out"
         style="width: {{ $progress }}%"></div>
</div>
```

## Transition Classes

```css
/* Slide transitions */
.slide-up-enter { transform: translateY(10px); opacity: 0; }
.slide-up-enter-active { transition: all 200ms ease-out; }
.slide-up-enter-to { transform: translateY(0); opacity: 1; }
.slide-up-leave { transform: translateY(0); opacity: 1; }
.slide-up-leave-active { transition: all 150ms ease-in; }
.slide-up-leave-to { transform: translateY(-10px); opacity: 0; }

/* Fade transitions */
.fade-enter { opacity: 0; }
.fade-enter-active { transition: opacity 200ms ease-out; }
.fade-enter-to { opacity: 1; }
.fade-leave { opacity: 1; }
.fade-leave-active { transition: opacity 150ms ease-in; }
.fade-leave-to { opacity: 0; }

/* Scale transitions */
.scale-enter { transform: scale(0.95); opacity: 0; }
.scale-enter-active { transition: all 200ms ease-out; }
.scale-enter-to { transform: scale(1); opacity: 1; }
.scale-leave { transform: scale(1); opacity: 1; }
.scale-leave-active { transition: all 150ms ease-in; }
.scale-leave-to { transform: scale(0.95); opacity: 0; }
```
