@props([
    'condition' => 'sunny',
    'temperature' => '72°F',
    'size' => 'md',
])

@php
$conditions = [
    'sunny' => ['icon' => '☀️', 'text' => 'text-yellow-600 dark:text-yellow-400'],
    'cloudy' => ['icon' => '☁️', 'text' => 'text-zinc-500 dark:text-zinc-400'],
    'rainy' => ['icon' => '🌧️', 'text' => 'text-blue-500'],
    'stormy' => ['icon' => '⛈️', 'text' => 'text-purple-500'],
    'snowy' => ['icon' => '❄️', 'text' => 'text-blue-300'],
];
$weather = $conditions[$condition] ?? $conditions['sunny'];
$sizes = ['sm' => 'text-xs gap-1', 'md' => 'text-sm gap-1.5', 'lg' => 'text-base gap-2'];
@endphp

<div {{ $attributes->class(['inline-flex items-center', $sizes[$size] ?? $sizes['md']]) }}>
    <span class="text-lg">{{ $weather['icon'] }}</span>
    <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $temperature }}</span>
</div>
