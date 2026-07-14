@blaze(fold: true)

@props([
    'position' => 'bottom',
    'align' => 'start',
    'offset' => 0,
    'gap' => 4,
    'hover' => false,
])

@php
$positionMap = [
    'top' => 'bottom-full mb-2',
    'bottom' => 'top-full mt-2',
    'left' => 'right-full mr-2',
    'right' => 'left-full ml-2',
];

$alignMap = [
    'start' => 'start-0',
    'center' => 'left-1/2 -translate-x-1/2',
    'end' => 'end-0',
];

$posClass = $positionMap[$position] ?? $positionMap['bottom'];
$alignClass = $alignMap[$align] ?? $alignMap['start'];

// For left/right positioned dropdowns, align affects vertical instead of horizontal
if (in_array($position, ['left', 'right'])) {
    $alignMapVert = [
        'start' => 'top-0',
        'center' => 'top-1/2 -translate-y-1/2',
        'end' => 'bottom-0',
    ];
    $alignClass = $alignMapVert[$align] ?? $alignMapVert['start'];
}
@endphp

@php
$hasNamedSlot = $slot?->menu ?? $slot?->content ?? false;
@endphp

<div
    {{ $attributes->class('relative inline-flex') }}
    @if ($hover)
        x-data="{ open: false }"
        @mouseenter="open = true"
        @mouseleave="open = false"
    @else
        x-data="{ open: false }"
        @keydown.escape.window="open = false"
    @endif
    data-gsmui-dropdown
>
    @if ($hasNamedSlot)
        <div @if (!$hover) @click="open = !open" @click.away="open = false" @endif>
            {{ $slot }}
        </div>

        <div
            class="absolute z-50 min-w-48 {{ $posClass }} {{ $alignClass }}"
            x-show="open"
            x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @if ($hover) @mouseenter="open = true" @mouseleave="open = false" @endif
            @if (!$hover) @click.away="open = false" @endif
            data-gsmui-dropdown-content
        >
            {{ $slot->menu ?? $slot->content ?? '' }}
        </div>
    @else
        <div @if (!$hover) @click="open = !open" @click.away="open = false" @endif data-gsmui-dropdown-trigger>
            {{ $slot?->trigger ?? $slot->first ?? '' }}
        </div>

        <div
            class="absolute z-50 min-w-48 {{ $posClass }} {{ $alignClass }}"
            x-show="open"
            x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @if ($hover) @mouseenter="open = true" @mouseleave="open = false" @endif
            @if (!$hover) @click.away="open = false" @endif
            data-gsmui-dropdown-content
        >
            {{ $slot }}
        </div>
    @endif
</div>
