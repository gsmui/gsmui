@props([
    'label' => 'Flat',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    'green' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    'red' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
    'yellow' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    'purple' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
