@blaze(fold: true)

@props([
    'brand' => null,
    'logo' => null,
    'logoAlt' => null,
    'href' => '/',
    'variant' => 'default',
    'behavior' => 'sticky',
    'color' => null,
    'sticky' => true,
    'transparent' => false,
    'searchable' => false,
    'searchPlaceholder' => __('Search...'),
    'searchValue' => null,
    'id' => null,
])

@php
$headerId = $id ?: 'header-' . str()->random(6);

$behaviorClass = match ($behavior) {
    'fixed' => 'fixed inset-x-0 top-0 z-50',
    'static' => 'relative',
    default => 'sticky inset-x-0 top-0 z-50',
};

$variantClasses = match ($variant) {
    'bordered' => 'border-b border-zinc-200 dark:border-zinc-800',
    'glass' => 'backdrop-blur-xl bg-white/80 dark:bg-zinc-900/80 border-b border-zinc-200/50 dark:border-zinc-800/50',
    'transparent' => $sticky ? 'bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm' : 'bg-transparent',
    'colored' => match ($color) {
        'blue' => 'bg-blue-600 text-white border-b border-blue-700',
        'violet' => 'bg-violet-600 text-white border-b border-violet-700',
        'emerald' => 'bg-emerald-600 text-white border-b border-emerald-700',
        'red' => 'bg-red-600 text-white border-b border-red-700',
        'amber' => 'bg-amber-500 text-white border-b border-amber-600',
        'zinc' => 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 border-b border-zinc-800 dark:border-zinc-200',
        default => 'bg-zinc-900 text-white border-b border-zinc-800',
    },
    default => 'bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800',
};

$classes = Gsmui::classes()
    ->add('flex items-center gap-3 px-4 sm:px-6 h-14 sm:h-16 transition-all duration-200')
    ->add($behaviorClass)
    ->add($variantClasses)
    ->add($transparent && $variant !== 'colored' && $variant !== 'transparent' ? 'bg-opacity-90 dark:bg-opacity-90' : '')
    ;

$brandClasses = Gsmui::classes()
    ->add('flex items-center gap-2.5 shrink-0')
    ;

$logoClasses = 'size-8 shrink-0 rounded-lg';

$brandTextClasses = Gsmui::classes()
    ->add('text-base sm:text-lg font-bold tracking-tight')
    ->add($variant === 'colored' ? 'text-inherit' : 'text-zinc-900 dark:text-white')
    ;

$navClasses = Gsmui::classes()
    ->add('hidden md:flex items-center gap-1 flex-1 px-4')
    ;

$actionsClasses = 'flex items-center gap-2 shrink-0';

$searchFormClasses = Gsmui::classes()
    ->add('hidden sm:flex items-center flex-1 max-w-md mx-auto')
    ;

$mobileToggleClasses = Gsmui::classes()
    ->add('flex md:hidden items-center justify-center size-9 rounded-lg')
    ->add($variant === 'colored'
        ? 'text-white/80 hover:text-white hover:bg-white/10'
        : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800')
    ;
@endphp

<header {{ $attributes->class($classes) }} data-gsmui-layout-header>
    <div class="flex items-center gap-3 w-full max-w-7xl mx-auto">
        {{-- Mobile menu toggle --}}
        @if ($slot?->nav ?? false)
            <button
                type="button"
                class="{{ $mobileToggleClasses }}"
                @click="$dispatch('toggle-nav-{{ $headerId }}')"
                aria-label="{{ __('Toggle navigation') }}"
                data-gsmui-header-toggle
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                </svg>
            </button>
        @endif

        {{-- Brand / Logo --}}
        <div class="{{ $brandClasses }}">
            @if ($logo)
                <img class="{{ $logoClasses }}" src="{{ $logo }}" alt="{{ $logoAlt ?? $brand ?? '' }}" />
            @elseif ($slot?->logo ?? false)
                <div class="{{ $logoClasses }}">{{ $slot->logo }}</div>
            @endif

            @if ($brand)
                @if ($href)
                    <a href="{{ $href }}" class="{{ $brandTextClasses }}" aria-label="{{ $brand }}">
                        {{ $brand }}
                    </a>
                @else
                    <span class="{{ $brandTextClasses }}">{{ $brand }}</span>
                @endif
            @endif

            {{ $slot?->brand ?? '' }}
        </div>

        {{-- Search --}}
        @if ($searchable)
            <div class="{{ $searchFormClasses }}">
                <div class="relative w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-zinc-400 dark:text-zinc-500 pointer-events-none">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                    <input
                        type="search"
                        placeholder="{{ $searchPlaceholder }}"
                        value="{{ $searchValue }}"
                        class="w-full h-9 pl-9 pr-3 text-sm rounded-lg bg-zinc-100 dark:bg-zinc-800 border-0 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-(--color-accent)"
                    />
                </div>
            </div>
        @endif

        {{-- Navigation --}}
        @if ($slot?->nav ?? false)
            <nav class="{{ $navClasses }}" data-gsmui-header-nav>
                {{ $slot->nav }}
            </nav>
        @endif

        {{-- Spacer (pushes actions to right when nav is empty) --}}
        @unless ($slot?->nav ?? false)
            <div class="flex-1"></div>
        @endunless

        {{-- Actions --}}
        @if ($slot?->actions ?? false)
            <div class="{{ $actionsClasses }}">
                {{ $slot->actions }}
            </div>
        @endif
    </div>
</header>
