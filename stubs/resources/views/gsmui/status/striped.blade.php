@props([
    'label' => 'Striped',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'text-blue-800 dark:text-blue-200',
    'green' => 'text-green-800 dark:text-green-200',
    'red' => 'text-red-800 dark:text-red-200',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-md bg-[length:4px_4px] bg-[linear-gradient(45deg,rgba(0,0,0,0.1)_25%,transparent_25%,transparent_50%,rgba(0,0,0,0.1)_50%,rgba(0,0,0,0.1)_75%,transparent_75%,transparent)] bg-blue-100 dark:bg-blue-900/30', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
