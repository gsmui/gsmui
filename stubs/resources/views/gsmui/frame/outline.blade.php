@props([
    'style' => 'dashed',
    'color' => 'zinc',
    'hover' => false,
])

@php
$styles = [
    'solid' => 'border-solid',
    'dashed' => 'border-dashed',
    'dotted' => 'border-dotted',
    'double' => 'border-double',
];

$colors = [
    'blue' => 'border-blue-400 dark:border-blue-500',
    'green' => 'border-green-400 dark:border-green-500',
    'purple' => 'border-purple-400 dark:border-purple-500',
    'red' => 'border-red-400 dark:border-red-500',
    'zinc' => 'border-zinc-300 dark:border-zinc-600',
];

$styleClass = $styles[$style] ?? 'border-dashed';
$colorClass = $colors[$color] ?? 'border-zinc-300';
@endphp

<div {{ $attributes->class([
    'border-2 rounded-xl',
    $styleClass,
    $colorClass,
    $hover ? 'hover:border-blue-500 transition-colors duration-200' : '',
]) }}>
    {{ $slot }}
</div>
