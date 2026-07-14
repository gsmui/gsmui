@props([
    'level' => 1,
    'label' => null,
    'status' => 'info',
    'size' => 'md',
])

@php
$defaultColors = [
    'success' => 'bg-green-500 text-white',
    'error' => 'bg-red-500 text-white',
    'warning' => 'bg-yellow-500 text-black',
    'info' => 'bg-blue-500 text-white',
];

$sizes = [
    'sm' => 'h-5 min-w-5 px-1 text-xs',
    'md' => 'h-6 min-w-6 px-1.5 text-xs',
    'lg' => 'h-7 min-w-7 px-2 text-sm',
];

$colorClass = $defaultColors[$status] ?? 'bg-zinc-500 text-white';
$sizeClass = $sizes[$size] ?? 'h-6 min-w-6 px-1.5 text-xs';
@endphp

<span {{ $attributes->class(['inline-flex items-center justify-center rounded-full font-bold tabular-nums', $sizeClass, $colorClass]) }}>
    {{ $label ?? $level }}
</span>
