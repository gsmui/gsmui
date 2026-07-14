@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'strokeWidth' => 10,
    'color' => 'blue',
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$radius = ($size - $strokeWidth) / 2;
$circumference = 2 * M_PI * $radius;
$offset = $circumference - ($percentage / 100) * $circumference;

$colors = [
    'blue' => ['track' => 'stroke-blue-100 dark:stroke-blue-900/30', 'progress' => 'stroke-blue-500 dark:stroke-blue-400', 'text' => 'text-blue-600 dark:text-blue-400'],
    'green' => ['track' => 'stroke-green-100 dark:stroke-green-900/30', 'progress' => 'stroke-green-500 dark:stroke-green-400', 'text' => 'text-green-600 dark:text-green-400'],
    'red' => ['track' => 'stroke-red-100 dark:stroke-red-900/30', 'progress' => 'stroke-red-500 dark:stroke-red-400', 'text' => 'text-red-600 dark:text-red-400'],
];
$colorSet = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="{{ $colorSet['track'] }}" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="{{ $colorSet['progress'] }}"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
    </svg>
    
    <div class="absolute inset-0 flex flex-col items-center justify-center">
        <span class="font-bold {{ $colorSet['text'] }}" style="font-size: {{ $size / 4 }}px; line-height: 1;">{{ round($percentage) }}</span>
        <span class="text-xs font-medium {{ $colorSet['text'] }} opacity-75">%</span>
    </div>
</div>
