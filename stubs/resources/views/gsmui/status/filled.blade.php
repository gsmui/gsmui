@props([
    'label' => 'Filled',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
    'green' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
    'red' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
    'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100',
    'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-800 dark:text-pink-100',
];
$colorClass = $colors[$color] ?? $colors['blue'];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-sm',
    'lg' => 'px-3 py-1.5 text-base',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<span {{ $attributes->class([
    'inline-flex items-center font-medium rounded-md',
    $colorClass,
    $sizeClass,
]) }}>
    {{ $label }}
</span>
