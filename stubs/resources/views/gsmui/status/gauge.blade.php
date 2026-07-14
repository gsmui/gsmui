@props([
    'value' => 0,
    'min' => 0,
    'max' => 100,
    'size' => 'md',
    'color' => 'blue',
])

@php
$range = $max - $min;
$percentage = $range > 0 ? (($value - $min) / $range) * 100 : 0;

$colors = [
    'blue' => ['#3b82f6', '#60a5fa'],
    'green' => ['#22c55e', '#4ade80'],
    'red' => ['#ef4444', '#f87171'],
    'amber' => ['#f59e0b', '#fbbf24'],
];

$sizes = [
    'sm' => 'w-20 h-12',
    'md' => 'w-28 h-16',
    'lg' => 'w-36 h-20',
];

$sizeClass = $sizes[$size] ?? 'w-28 h-16';
$strokeColor = $colors[$color] ?? ['#3b82f6', '#60a5fa'];
@endphp

<div {{ $attributes->class(['relative inline-flex items-end justify-center', $sizeClass]) }}>
    <svg viewBox="0 0 100 60" class="w-full h-full">
        <defs>
            <linearGradient id="gauge-grad-{{ md5($color) }}" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="{{ $strokeColor[0] }}"/>
                <stop offset="100%" stop-color="{{ $strokeColor[1] }}"/>
            </linearGradient>
        </defs>
        <path d="M 10 55 A 40 40 0 0 1 90 55" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round" class="text-zinc-200 dark:text-zinc-700"/>
        <path d="M 10 55 A 40 40 0 0 1 90 55" fill="none" stroke-width="8" stroke-linecap="round" stroke="url(#gauge-grad-{{ md5($color) }})" stroke-dasharray="126" stroke-dashoffset="{{ 126 - ($percentage / 100 * 126) }}"/>
    </svg>
    <span class="absolute bottom-0 text-xs font-bold tabular-nums">{{ round($value) }}</span>
</div>
