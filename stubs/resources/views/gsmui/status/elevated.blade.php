@props([
    'label' => 'Elevated',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-white dark:bg-zinc-800 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800',
    'green' => 'bg-white dark:bg-zinc-800 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-800',
    'red' => 'bg-white dark:bg-zinc-800 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-lg shadow-lg', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
