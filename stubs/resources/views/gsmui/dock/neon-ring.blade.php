@props([
    'items' => [],
    'color' => 'cyan',
])

@php
$colors = [
    'cyan' => ['border' => 'border-cyan-500', 'shadow' => 'shadow-[0_0_20px_rgba(6,182,212,0.5)]', 'text' => 'text-cyan-400'],
    'magenta' => ['border' => 'border-pink-500', 'shadow' => 'shadow-[0_0_20px_rgba(236,72,153,0.5)]', 'text' => 'text-pink-400'],
    'green' => ['border' => 'border-green-500', 'shadow' => 'shadow-[0_0_20px_rgba(34,197,94,0.5)]', 'text' => 'text-green-400'],
];
$colorSet = $colors[$color] ?? $colors['cyan'];
@endphp

<div {{ $attributes->class([
    'flex items-center gap-3 z-50',
    'fixed bottom-4 left-1/2 -translate-x-1/2',
    'bg-zinc-950/90 backdrop-blur-xl rounded-full p-3',
    'border-2', $colorSet['border'], $colorSet['shadow'],
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? $colorSet['text'] . ' bg-white/10' 
                          : 'text-zinc-500 hover:' . $colorSet['text'] }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.2 : 1}); box-shadow: ${hovered === {{ $index }} ? '0 0 15px currentColor' : 'none'};`">
                <span class="text-base">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
