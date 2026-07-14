@props([
    'items' => [],
    'position' => 'bottom',
    'gradient' => 'blue-purple',
])

@php
$gradients = [
    'blue-purple' => 'from-blue-600 via-purple-600 to-indigo-600',
    'green-teal' => 'from-emerald-500 via-teal-500 to-cyan-500',
    'orange-red' => 'from-orange-500 via-red-500 to-pink-500',
    'indigo-violet' => 'from-indigo-500 via-purple-500 to-violet-500',
    'slate-zinc' => 'from-slate-700 via-slate-800 to-zinc-900',
];
$gradientClass = $gradients[$gradient] ?? $gradients['blue-purple'];

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};
@endphp

<div {{ $attributes->class([
    'flex items-center gap-2 z-50',
    $positionClass,
    'bg-gradient-to-r', $gradientClass,
    'rounded-2xl p-2 shadow-2xl',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white/25 text-white' 
                          : 'text-white/70 hover:bg-white/15 hover:text-white' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.1 : 1})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
