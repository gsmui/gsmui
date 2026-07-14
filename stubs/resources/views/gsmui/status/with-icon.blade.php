@props([
    'label' => 'With Icon',
    'icon' => '✓',
    'color' => 'green',
    'size' => 'md',
])

@php
$colors = [
    'green' => 'text-green-600 dark:text-green-400',
    'red' => 'text-red-600 dark:text-red-400',
    'yellow' => 'text-yellow-600 dark:text-yellow-400',
    'blue' => 'text-blue-600 dark:text-blue-400',
    'purple' => 'text-purple-600 dark:text-purple-400',
];
$colorClass = $colors[$color] ?? $colors['green'];
$sizes = ['sm' => 'text-xs gap-1', 'md' => 'text-sm gap-1.5', 'lg' => 'text-base gap-2'];
@endphp

<div {{ $attributes->class(['inline-flex items-center font-medium', $sizes[$size] ?? $sizes['md']]) }}>
    <span class="{{ $colorClass }}">{{ $icon }}</span>
    <span class="text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
</div>
