@props([
    'items' => [],
    'position' => 'bottom',
    'color' => 'slate',
])

@php
$colors = [
    'slate' => 'bg-slate-900',
    'gray' => 'bg-gray-900',
    'zinc' => 'bg-zinc-900',
    'neutral' => 'bg-neutral-900',
    'stone' => 'bg-stone-900',
];
$colorClass = $colors[$color] ?? $colors['slate'];

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};
@endphp

<div {{ $attributes->class([
    'flex items-center gap-2 z-50',
    $positionClass,
    $colorClass,
    'rounded-2xl p-2 shadow-xl',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white/20 text-white' 
                          : 'text-zinc-400 hover:bg-white/10 hover:text-white' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.1 : 1})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
