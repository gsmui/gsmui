@props([
    'items' => [],
    'color' => 'blue',
    'position' => 'bottom',
])

@php
$colors = [
    'blue' => ['glow' => 'shadow-[0_0_15px_rgba(59,130,246,0.5)]', 'hover' => 'hover:bg-blue-500/20', 'active' => 'bg-blue-500/30 text-blue-400', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30'],
    'purple' => ['glow' => 'shadow-[0_0_15px_rgba(168,85,247,0.5)]', 'hover' => 'hover:bg-purple-500/20', 'active' => 'bg-purple-500/30 text-purple-400', 'text' => 'text-purple-400', 'border' => 'border-purple-500/30'],
    'green' => ['glow' => 'shadow-[0_0_15px_rgba(34,197,94,0.5)]', 'hover' => 'hover:bg-green-500/20', 'active' => 'bg-green-500/30 text-green-400', 'text' => 'text-green-400', 'border' => 'border-green-500/30'],
    'cyan' => ['glow' => 'shadow-[0_0_15px_rgba(6,182,212,0.5)]', 'hover' => 'hover:bg-cyan-500/20', 'active' => 'bg-cyan-500/30 text-cyan-400', 'text' => 'text-cyan-400', 'border' => 'border-cyan-500/30'],
    'pink' => ['glow' => 'shadow-[0_0_15px_rgba(236,72,153,0.5)]', 'hover' => 'hover:bg-pink-500/20', 'active' => 'bg-pink-500/30 text-pink-400', 'text' => 'text-pink-400', 'border' => 'border-pink-500/30'],
];
$colorSet = $colors[$color] ?? $colors['blue'];

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
    'border', $colorSet['border'],
    $colorSet['glow'],
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300
                      {{ ($item['active'] ?? false) ? $colorSet['active'] : $colorSet['hover'] . ' text-zinc-400' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.2 : 1})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            @if(isset($item['badge']) && $item['badge'])
                <div class="absolute -top-1 -right-1 w-4 h-4 flex items-center justify-center bg-red-500 text-white text-[9px] font-bold rounded-full">
                    {{ $item['badge'] }}
                </div>
            @endif
        </div>
    @endforeach
</div>
