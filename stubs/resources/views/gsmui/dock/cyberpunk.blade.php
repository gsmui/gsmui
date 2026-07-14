@props([
    'items' => [],
    'position' => 'bottom',
    'color' => 'cyan',
])

@php
$glowColors = [
    'cyan' => ['glow' => 'shadow-[0_0_15px_rgba(6,182,212,0.6)]', 'border' => 'border-cyan-500/50', 'text' => 'text-cyan-400', 'bg' => 'bg-cyan-500/20'],
    'magenta' => ['glow' => 'shadow-[0_0_15px_rgba(236,72,153,0.6)]', 'border' => 'border-pink-500/50', 'text' => 'text-pink-400', 'bg' => 'bg-pink-500/20'],
    'green' => ['glow' => 'shadow-[0_0_15px_rgba(34,197,94,0.6)]', 'border' => 'border-green-500/50', 'text' => 'text-green-400', 'bg' => 'bg-green-500/20'],
];
$colorSet = $glowColors[$color] ?? $glowColors['cyan'];

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};
@endphp

<div {{ $attributes->class([
    'flex items-center gap-1.5 z-50',
    $positionClass,
    'bg-zinc-950/90 backdrop-blur-xl rounded-xl p-2',
    'border', $colorSet['border'],
    $colorSet['glow'],
]) }}
    x-data="{ hovered: null }">
    
    {{-- Scan line effect --}}
    <div class="absolute inset-0 rounded-xl overflow-hidden pointer-events-none opacity-10">
        <div class="absolute inset-0 bg-[repeating-linear-gradient(0deg,transparent,transparent_2px,rgba(255,255,255,0.03)_2px,rgba(255,255,255,0.03)_4px)]"></div>
    </div>
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="relative flex items-center justify-center w-11 h-11 rounded-lg transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? $colorSet['bg'] . ' ' . $colorSet['text'] . ' border ' . $colorSet['border']
                          : 'text-zinc-500 hover:' . $colorSet['text'] . ' hover:bg-white/5' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.15 : 1}); text-shadow: ${hovered === {{ $index }} ? '0 0 10px currentColor' : 'none'};`">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
