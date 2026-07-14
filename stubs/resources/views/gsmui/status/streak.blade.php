@props([
    'count' => 0,
    'size' => 'md',
    'color' => 'orange',
])

@php
$colors = [
    'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
    'red' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
];

$sizes = [
    'sm' => 'px-1.5 py-0.5 text-[10px] gap-1',
    'md' => 'px-2 py-0.5 text-xs gap-1.5',
    'lg' => 'px-2.5 py-1 text-sm gap-1.5',
];

$colorClass = $colors[$color] ?? $colors['orange'];
$sizeClass = $sizes[$size] ?? 'px-2 py-0.5 text-xs gap-1.5';
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-full font-semibold tabular-nums', $sizeClass, $colorClass]) }}>
    🔥 {{ $count }} day streak
</span>
