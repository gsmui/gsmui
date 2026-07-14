@props([
    'label' => 'Published',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'text-blue-600 dark:text-blue-400',
    'green' => 'text-green-600 dark:text-green-400',
    'red' => 'text-red-600 dark:text-red-400',
    'yellow' => 'text-yellow-600 dark:text-yellow-400',
    'purple' => 'text-purple-600 dark:text-purple-400',
    'pink' => 'text-pink-600 dark:text-pink-400',
    'indigo' => 'text-indigo-600 dark:text-indigo-400',
    'zinc' => 'text-zinc-600 dark:text-zinc-400',
];
$colorClass = $colors[$color] ?? $colors['blue'];

$sizes = [
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<span {{ $attributes->class([
    'inline-flex items-center font-semibold',
    $colorClass,
    $sizeClass,
]) }}>
    {{ $label }}
</span>
