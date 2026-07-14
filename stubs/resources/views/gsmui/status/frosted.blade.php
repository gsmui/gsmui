@props([
    'label' => 'Frosted',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-white/40 dark:bg-zinc-800/40 backdrop-blur-xl text-blue-600 dark:text-blue-400 border border-white/30',
    'green' => 'bg-white/40 dark:bg-zinc-800/40 backdrop-blur-xl text-green-600 dark:text-green-400 border border-white/30',
    'red' => 'bg-white/40 dark:bg-zinc-800/40 backdrop-blur-xl text-red-600 dark:text-red-400 border border-white/30',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-lg', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
