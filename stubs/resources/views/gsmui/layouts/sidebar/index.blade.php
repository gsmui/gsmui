@blaze(fold: true)

@props([
    'type' => 'sidebar',
    'position' => 'left',
    'width' => null,
    'variant' => null,
    'color' => null,
    'behavior' => null,
    'collapsible' => false,
    'mini' => false,
    'open' => false,
    'overlay' => false,
    'push' => false,
    'id' => null,
    'responsive' => false,
    'breakpoint' => 'md',
])

@php
$sidebarId = $id ?: 'sidebar-' . str()->random(6);

// === Responsive ===
$isResponsive = $responsive || $type === 'responsive';
$breakpointPx = match ($breakpoint) {
    'sm' => 640,
    'lg' => 1024,
    'xl' => 1280,
    '2xl' => 1536,
    default => 768,
};
// Responsive hidden/show utility classes
$responsiveHidden = match ($breakpoint) {
    'sm' => 'sm:hidden',
    'lg' => 'lg:hidden',
    'xl' => 'xl:hidden',
    '2xl' => '2xl:hidden',
    default => 'md:hidden',
};
$responsiveVisible = match ($breakpoint) {
    'sm' => 'sm:flex',
    'lg' => 'lg:flex',
    'xl' => 'xl:flex',
    '2xl' => '2xl:flex',
    default => 'md:flex',
};

// === Type ===
$isDrawer = $type === 'drawer';
$isOverlay = $overlay || $type === 'overlay';
$isPush = $push || $type === 'push';
$isSlide = $type === 'slide';
$isFloating = $type === 'floating';
$isInset = $type === 'inset';
$isRail = $type === 'rail' || $mini;

$isAlpine = $isDrawer || $isOverlay || $isSlide || $isPush;

// === Position ===
$isRight = $position === 'right';

// === Width ===
$widthClass = match ($width) {
    'xs' => 'w-48',
    'sm' => 'w-56',
    'lg' => 'w-72',
    'xl' => 'w-80',
    'full' => 'w-full max-w-sm',
    default => 'w-64',
};

// Push margin for content area (must match widthClass values)
$pushMarginMap = [
    'xs' => ['left' => 'ml-48', 'right' => 'mr-48'],
    'sm' => ['left' => 'ml-56', 'right' => 'mr-56'],
    'lg' => ['left' => 'ml-72', 'right' => 'mr-72'],
    'xl' => ['left' => 'ml-80', 'right' => 'mr-80'],
    'full' => ['left' => 'ml-96', 'right' => 'mr-96'],
    'default' => ['left' => 'ml-64', 'right' => 'mr-64'],
];
$pushMargin = $pushMarginMap[$width] ?? $pushMarginMap['default'];

// === Variant (visual style) ===
$variantClasses = match ($variant) {
    'bordered' => 'border-r border-zinc-200 dark:border-zinc-700',
    'elevated' => 'shadow-lg shadow-zinc-200/50 dark:shadow-zinc-900/50 border-r border-zinc-100 dark:border-zinc-800',
    'floating' => 'm-3 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-700',
    'glass' => 'backdrop-blur-xl bg-white/80 dark:bg-zinc-900/80 border-r border-white/20 dark:border-zinc-700/50',
    'neo' => 'shadow-[2px_0_12px_rgba(0,0,0,0.05)] dark:shadow-[2px_0_12px_rgba(0,0,0,0.3)]',
    'gradient' => 'bg-gradient-to-b from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-950',
    'dark' => 'bg-zinc-900 text-white border-r border-zinc-800',
    'colored' => match ($color) {
        'blue' => 'bg-blue-600 text-white',
        'violet' => 'bg-violet-600 text-white',
        'emerald' => 'bg-emerald-600 text-white',
        'red' => 'bg-red-600 text-white',
        default => 'bg-zinc-900 text-white',
    },
    default => 'bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800',
};

// === Behavior ===
$behaviorClasses = match ($behavior) {
    'fixed' => 'fixed inset-y-0 z-30',
    'sticky' => 'sticky top-0 h-screen',
    'absolute' => 'absolute inset-y-0 z-30',
    default => 'h-screen',
};

// === Full classes ===
$sidebarClasses = Gsmui::classes()
    ->add('flex flex-col overflow-y-auto shrink-0 transition-all duration-300 ease-in-out')
    ->add($behaviorClasses)
    ->add($variantClasses)
    ->add($widthClass)
    ->add($isRight ? ($isFloating ? 'right-3' : 'right-0 border-l border-r-0') : ($isFloating ? 'left-3' : 'left-0'))
    ->add($isFloating ? 'top-3 bottom-3 h-auto rounded-xl' : '')
    ->add($isInset ? 'relative h-full border rounded-xl shadow-sm' : '')
    ->add($isRail ? 'w-16!' : '')
    ;

// Overlay / drawer backdrop
$showOverlay = $isDrawer || $isOverlay;
$mobileClasses = $showOverlay ? 'fixed inset-y-0 z-40' : '';
$backdropClasses = $showOverlay ? 'fixed inset-0 z-30 bg-black/50 dark:bg-black/70 transition-opacity duration-300' : '';
@endphp

@if ($isResponsive)
    {{--
        Responsive mode: sidebar is a drawer on mobile (overlay with backdrop)
        and a static panel on desktop (always visible).
        Uses Alpine to track viewport width via window.innerWidth.
    --}}
    <div
        x-data="{
            open: {{ $open ? 'true' : 'false' }},
            isDesktop: false,
            bp: {{ $breakpointPx }},
            checkViewport() {
                this.isDesktop = window.innerWidth >= this.bp;
                if (this.isDesktop) this.open = true;
            }
        }"
        x-init="checkViewport()"
        @resize.window="checkViewport()"
        @toggle-sidebar-{{ $sidebarId }}.window="open = !open; if (isDesktop) open = true"
        data-gsmui-sidebar
    >
        {{-- Backdrop (mobile only — hidden at breakpoint) --}}
        <div
            class="fixed inset-0 z-30 bg-black/50 dark:bg-black/70 transition-opacity duration-300 {{ $responsiveHidden }}"
            x-show="open && !isDesktop"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="open = false"
        ></div>

        {{-- Sidebar panel --}}
        {{-- On mobile: fixed overlay, slides in from side --}}
        {{-- On desktop: static positioning per behavior prop --}}
        <div
            class="flex flex-col overflow-y-auto shrink-0 transition-all duration-300 ease-in-out"
            :class="isDesktop
                ? '{{ $behaviorClasses }} {{ $widthClass }} {{ $variantClasses }} {{ $isRight ? 'right-0 border-l border-r-0' : 'left-0' }} relative z-0 shadow-none'
                : 'fixed inset-y-0 z-40 {{ $isRight ? 'right-0' : 'left-0' }} {{ $widthClass }} {{ $variantClasses }} shadow-2xl'
            "
            x-ref="sidebarPanel"
            x-show="open || isDesktop"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="{{ $isRight ? 'translate-x-full' : '-translate-x-full' }} {{ $breakpoint }}:translate-x-0"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="{{ $isRight ? 'translate-x-full' : '-translate-x-full' }} {{ $breakpoint }}:translate-x-0"
            @click.away="if (!isDesktop) open = false"
            @keydown.escape.window="if (!isDesktop) open = false"
        >
            {{ $slot }}
        </div>
    </div>
@elseif ($isAlpine)
    <div
        x-data="{ open: {{ $open ? 'true' : 'false' }}, id: '{{ $sidebarId }}' }"
        @toggle-sidebar-{{ $sidebarId }}.window="open = !open"
        data-gsmui-sidebar
    >
        {{-- Backdrop for overlay/drawer --}}
        @if ($showOverlay)
            <div
                class="{{ $backdropClasses }}"
                x-show="open"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="open = false"
            ></div>
        @endif

        {{-- Sidebar panel with transition --}}
        <div
            class="{{ $sidebarClasses }} {{ $mobileClasses }}"
            x-ref="sidebarPanel"
            x-show="open"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="{{ $isRight ? 'translate-x-full' : '-translate-x-full' }}"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="{{ $isRight ? 'translate-x-full' : '-translate-x-full' }}"
            @click.away="open = false"
            @keydown.escape.window="open = false"
        >
            {{ $slot }}
        </div>

        {{-- Main content wrapper for push/slide — uses a named 'content' slot so it doesn't duplicate --}}
        @if ($isPush || $isSlide)
            <div
                class="transition-all duration-300 ease-in-out"
                :class="open ? '{{ $isRight ? $pushMargin['right'] : $pushMargin['left'] }}' : ''"
            >
                {{ $slot?->content ?? '' }}
            </div>
        @endif
    </div>
@else
    {{-- Static sidebar (always visible, no Alpine needed) --}}
    <div {{ $attributes->class($sidebarClasses) }} data-gsmui-sidebar>
        {{ $slot }}
    </div>
@endif
