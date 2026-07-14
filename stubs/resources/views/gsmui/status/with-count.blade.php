@props([
    'label' => 'Items',
    'count' => 0,
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
    'green' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
    'red' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    'yellow' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
];
$colorClass = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-bold {{ $colorClass }}">
        {{ $count }}
    </span>
</div>
