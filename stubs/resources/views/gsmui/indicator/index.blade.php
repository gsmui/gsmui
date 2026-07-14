@blaze(fold: true, unsafe: ['label'])

@props([
    'position' => 'top-end',
    'color' => null,
    'size' => null,
    'label' => null,
    'as' => null,
    'href' => null,
    'disabled' => false,
    'offset' => false,
    'ping' => false,
])

@php
$isLink = $href && $as !== 'div';
$tag = $as ?: ($isLink ? 'a' : 'div');

// Extract named slot presence BEFORE rendering default slot to avoid double render
$hasCustomItem = ($slot?->item ?? false) !== false;

$classes = Gsmui::classes()
    ->add('relative inline-flex')
    ;

$itemClasses = Gsmui::classes()
    ->add('absolute z-[1] flex items-center justify-center')
    ->add(match ($position) {
        'top-start' => 'top-0 start-0 -translate-x-1/4 -translate-y-1/4',
        'top-center' => 'top-0 left-1/2 -translate-x-1/2 -translate-y-1/2',
        'top-end' => 'top-0 end-0 translate-x-1/4 -translate-y-1/4',
        'middle-start' => 'top-1/2 start-0 -translate-x-1/2 -translate-y-1/2',
        'middle-center' => 'top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2',
        'middle-end' => 'top-1/2 end-0 translate-x-1/2 -translate-y-1/2',
        'bottom-start' => 'bottom-0 start-0 -translate-x-1/4 translate-y-1/4',
        'bottom-center' => 'bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2',
        'bottom-end' => 'bottom-0 end-0 translate-x-1/4 translate-y-1/4',
        default => 'top-0 end-0 translate-x-1/4 -translate-y-1/4',
    })
    ->add($offset ? 'm-0.5' : '')
    ;

// Map color names to explicit bg+ping colors (so ping uses bg color, not text color)
$colorMap = match ($color) {
    'primary' => ['badge' => 'bg-blue-600 text-white', 'ping' => 'bg-blue-600'],
    'secondary' => ['badge' => 'bg-violet-600 text-white', 'ping' => 'bg-violet-600'],
    'accent' => ['badge' => 'bg-amber-500 text-white', 'ping' => 'bg-amber-500'],
    'success' => ['badge' => 'bg-emerald-500 text-white', 'ping' => 'bg-emerald-500'],
    'warning' => ['badge' => 'bg-yellow-500 text-white', 'ping' => 'bg-yellow-500'],
    'danger' => ['badge' => 'bg-red-500 text-white', 'ping' => 'bg-red-500'],
    'info' => ['badge' => 'bg-sky-500 text-white', 'ping' => 'bg-sky-500'],
    'neutral' => ['badge' => 'bg-zinc-700 text-white dark:bg-zinc-600', 'ping' => 'bg-zinc-700 dark:bg-zinc-600'],
    'ghost' => ['badge' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300', 'ping' => 'bg-zinc-300 dark:bg-zinc-600'],
    default => ['badge' => 'bg-red-500 text-white', 'ping' => 'bg-red-500'],
};

$badgeClasses = Gsmui::classes()
    ->add('font-medium leading-none whitespace-nowrap select-none')
    ->add(match ($size) {
        'xs' => 'h-4 min-w-4 px-1 text-[9px] rounded-full',
        'sm' => 'h-5 min-w-5 px-1.5 text-[10px] rounded-full',
        'lg' => 'h-7 min-w-7 px-2.5 text-xs rounded-full',
        'xl' => 'h-8 min-w-8 px-3 text-sm rounded-full',
        default => 'h-6 min-w-6 px-2 text-[11px] rounded-full',
    })
    ->add($colorMap['badge'])
    ;

$pingClasses = $ping ? 'absolute inset-0 rounded-full ' . $colorMap['ping'] . ' opacity-75 animate-ping' : '';
@endphp

<{{ $tag }}
    @if ($isLink) href="{{ $href }}" @endif
    {{ $attributes->class($classes) }}
    @if ($disabled) aria-disabled="true" @endif
    data-gsmui-indicator
>
    {{-- Indicator badge/item overlay — rendered first so it stays separate from content slot --}}
    @if ($label || $hasCustomItem)
        <div class="{{ $itemClasses }}">
            @if ($hasCustomItem)
                {{ $slot->item }}
            @else
                <span class="relative inline-flex {{ $badgeClasses }}">
                    @if ($ping)
                        <span class="{{ $pingClasses }}"></span>
                    @endif
                    <span class="relative z-[2]">{{ $label }}</span>
                </span>
            @endif
        </div>
    @endif

    {{-- Main content — default slot only (named slots already extracted) --}}
    {{ $slot }}
</{{ $tag }}>
