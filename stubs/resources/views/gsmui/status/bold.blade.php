@props([
    'label' => 'Bold',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-500 text-white',
    'green' => 'bg-green-500 text-white',
    'red' => 'bg-red-500 text-white',
    'yellow' => 'bg-yellow-500 text-white',
    'purple' => 'bg-purple-500 text-white',
    'pink' => 'bg-pink-500 text-white',
];
$colorClass = $colors[$color] ?? $colors['blue'];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-sm',
    'lg' => 'px-3 py-1.5 text-base',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<span {{ $attributes->class([
    'inline-flex items-center font-bold rounded-md',
    $colorClass,
    $sizeClass,
]) }}>
    {{ $label }}
</span>
