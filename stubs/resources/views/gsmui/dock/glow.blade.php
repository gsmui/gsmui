@props([
    'items' => [],
    'position' => 'bottom',
    'color' => 'blue',
])

@php
$glowColors = [
    'blue' => 'shadow-[0_0_20px_rgba(59,130,246,0.4)]',
    'purple' => 'shadow-[0_0_20px_rgba(168,85,247,0.4)]',
    'green' => 'shadow-[0_0_20px_rgba(34,197,94,0.4)]',
    'cyan' => 'shadow-[0_0_20px_rgba(6,182,212,0.4)]',
    'pink' => 'shadow-[0_0_20px_rgba(236,72,153,0.4)]',
    'amber' => 'shadow-[0_0_20px_rgba(245,158,11,0.4)]',
];
$glowClass = $glowColors[$color] ?? $glowColors['blue'];

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};
@endphp

<div {{ $attributes->class([
    'flex items-center gap-2 z-50',
    $positionClass,
    'bg-zinc-900 dark:bg-zinc-950 rounded-2xl p-2',
    $glowClass,
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white/20 text-white' 
                          : 'text-zinc-400 hover:bg-white/10 hover:text-white' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.2 : 1})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
