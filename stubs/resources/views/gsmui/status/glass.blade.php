@props([
    'label' => 'Glass',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-500/20 backdrop-blur-md text-blue-700 dark:text-blue-300 border border-blue-500/30',
    'green' => 'bg-green-500/20 backdrop-blur-md text-green-700 dark:text-green-300 border border-green-500/30',
    'red' => 'bg-red-500/20 backdrop-blur-md text-red-700 dark:text-red-300 border border-red-500/30',
    'purple' => 'bg-purple-500/20 backdrop-blur-md text-purple-700 dark:text-purple-300 border border-purple-500/30',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-lg', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
