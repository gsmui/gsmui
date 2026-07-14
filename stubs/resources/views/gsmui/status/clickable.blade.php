@props([
    'label' => 'Clickable',
    'href' => '#',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400',
    'green' => 'bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400',
    'red' => 'bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<a href="{{ $href }}" {{ $attributes->class(['inline-flex items-center font-medium rounded-md cursor-pointer transition-colors', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</a>
