@props([
    'label' => 'Subtle',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400',
    'green' => 'bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400',
    'red' => 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400',
    'yellow' => 'bg-yellow-50 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400',
    'purple' => 'bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400',
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
