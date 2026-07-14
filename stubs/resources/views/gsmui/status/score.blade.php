@props([
    'score' => 0,
    'max' => 100,
    'status' => 'info',
    'size' => 'md',
])

@php
$defaultColors = [
    'success' => 'bg-green-500 text-white',
    'error' => 'bg-red-500 text-white',
    'warning' => 'bg-yellow-500 text-white',
    'info' => 'bg-blue-500 text-white',
];

$sizes = [
    'sm' => 'h-10 w-10 text-xs',
    'md' => 'h-12 w-12 text-sm',
    'lg' => 'h-14 w-14 text-base',
];

$colorClass = $defaultColors[$status] ?? 'bg-zinc-500 text-white';
$sizeClass = $sizes[$size] ?? 'h-12 w-12 text-sm';
$percentage = $max > 0 ? round(($score / $max) * 100) : 0;
@endphp

<div {{ $attributes->class(['inline-flex items-center justify-center rounded-full font-semibold tabular-nums', $sizeClass, $colorClass]) }}>
    {{ $percentage }}
</div>
