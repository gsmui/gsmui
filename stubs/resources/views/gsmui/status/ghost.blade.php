@props([
    'label' => 'Ghost',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20',
    'green' => 'text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20',
    'red' => 'text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20',
    'yellow' => 'text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20',
    'purple' => 'text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20',
    'zinc' => 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800',
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
    'inline-flex items-center font-medium rounded-md transition-colors',
    $colorClass,
    $sizeClass,
]) }}>
    {{ $label }}
</span>
