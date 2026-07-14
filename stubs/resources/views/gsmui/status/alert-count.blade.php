@props([
    'count' => 0,
    'max' => 99,
    'status' => 'error',
    'size' => 'md',
    'pulse' => false,
])

@php
$defaultColors = [
    'success' => 'bg-green-500',
    'error' => 'bg-red-500',
    'warning' => 'bg-yellow-500',
    'info' => 'bg-blue-500',
];

$sizes = [
    'sm' => 'h-4 min-w-4 px-1 text-[10px]',
    'md' => 'h-5 min-w-5 px-1.5 text-xs',
    'lg' => 'h-6 min-w-6 px-2 text-sm',
];

$colorClass = $defaultColors[$status] ?? 'bg-red-500';
$sizeClass = $sizes[$size] ?? 'h-5 min-w-5 px-1.5 text-xs';
$display = $count > $max ? $max . '+' : $count;
@endphp

<span @class([
    'inline-flex items-center justify-center rounded-full font-bold text-white tabular-nums',
    $sizeClass,
    $colorClass,
    $pulse && $count > 0 => 'animate-pulse',
]) {{ $attributes }}>
    {{ $display }}
</span>
