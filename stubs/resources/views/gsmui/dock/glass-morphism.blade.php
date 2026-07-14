@props([
    'items' => [],
    'position' => 'bottom',
    'tint' => 'blue',
])

@php
$tints = [
    'blue' => 'bg-blue-500/10 border-blue-500/20',
    'purple' => 'bg-purple-500/10 border-purple-500/20',
    'green' => 'bg-green-500/10 border-green-500/20',
    'pink' => 'bg-pink-500/10 border-pink-500/20',
];
$tintClass = $tints[$tint] ?? $tints['blue'];

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};
@endphp

<div {{ $attributes->class([
    'flex items-center gap-2 z-50',
    $positionClass,
    'backdrop-blur-[30px]',
    $tintClass,
    'rounded-2xl p-2.5',
    'border',
    'shadow-[0_8px_32px_rgba(0,0,0,0.1)]',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white/25 text-white shadow-inner' 
                          : 'text-white/70 hover:bg-white/15' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-6px' : '0'}) scale(${hovered === {{ $index }} ? 1.08 : 1})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
