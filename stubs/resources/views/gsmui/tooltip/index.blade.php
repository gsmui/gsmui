@blaze(fold: true)

@props([
    'content' => null,
    'position' => 'top',
    'align' => 'center',
    'disabled' => false,
    'gap' => 5,
    'offset' => 0,
    'toggleable' => false,
    'interactive' => false,
    'kbd' => null,
])

@php
$positionClass = match ($position) {
    'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
    'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
    'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
    default => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
};

$alignClass = match ($align) {
    'start' => match ($position) {
        'top', 'bottom' => 'left-0 -translate-x-0',
        'left', 'right' => 'top-0 -translate-y-0',
        default => '',
    },
    'end' => match ($position) {
        'top', 'bottom' => 'right-0 left-auto -translate-x-0',
        'left', 'right' => 'bottom-0 top-auto -translate-y-0',
        default => '',
    },
    default => '',
};

$isToggleable = $toggleable || $interactive;
@endphp

<div
    {{ $attributes->class('relative') }}
    x-data="{ open: false }"
    @if ($isToggleable)
        @click="open = !open"
        @click.away="open = false"
        @mouseenter="open = true"
        @mouseleave="open = false"
    @else
        @mouseenter="open = true"
        @mouseleave="open = false"
        @focusin="open = true"
        @focusout="open = false"
    @endif
    @if ($disabled) aria-disabled="true" @endif
    data-gsmui-tooltip
>
    <div>
        {{ $slot }}
    </div>

    <div
        class="absolute z-50 {{ $positionClass }} {{ $alignClass }} px-2 py-1 text-xs font-medium text-white bg-zinc-900 dark:bg-zinc-700 rounded-md shadow-sm whitespace-nowrap transition-opacity duration-150"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @if ($interactive) role="tooltip" id="tooltip-{{ str()->random(6) }}" @endif
        @if (!$interactive) pointer-events-none @endif
        data-gsmui-tooltip-content
    >
        @if ($content)
            {{ $content }}
        @endif

        @if ($kbd || $slot?->content ?? false)
            {{ $slot->content ?? '' }}
        @endif

        @if ($kbd)
            <kbd class="ml-2 rounded border border-white/20 px-1 py-0.5 text-[10px]">{{ $kbd }}</kbd>
        @endif
    </div>
</div>
