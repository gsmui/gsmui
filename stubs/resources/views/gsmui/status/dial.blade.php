@props([
    'value' => 50,
    'max' => 100,
    'size' => 'md',
    'color' => 'blue',
])

@php
$percentage = $max > 0 ? ($value / $max) * 100 : 0;
$rotation = ($percentage / 100) * 180;

$colors = [
    'blue' => 'stroke-blue-500',
    'green' => 'stroke-green-500',
    'red' => 'stroke-red-500',
    'yellow' => 'stroke-yellow-500',
];

$sizes = [
    'sm' => 'h-8 w-16',
    'md' => 'h-10 w-20',
    'lg' => 'h-12 w-24',
];

$colorClass = $colors[$color] ?? 'stroke-blue-500';
$sizeClass = $sizes[$size] ?? 'h-10 w-20';
@endphp

<div {{ $attributes->class(['inline-flex flex-col items-center', $sizeClass]) }}>
    <svg viewBox="0 0 100 50" class="w-full h-1/2">
        <path d="M 10 45 A 40 40 0 0 1 90 45" fill="none" stroke="currentColor" stroke-width="6" class="text-zinc-200 dark:text-zinc-700"/>
        <path d="M 10 45 A 40 40 0 0 1 90 45" fill="none" stroke-width="6" stroke-linecap="round" class="{{ $colorClass }}" stroke-dasharray="126" stroke-dashoffset="{{ 126 - ($percentage / 100 * 126) }}"/>
    </svg>
    <span class="text-xs font-semibold tabular-nums">{{ round($percentage) }}%</span>
</div>
