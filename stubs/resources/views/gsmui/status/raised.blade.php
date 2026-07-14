@props([
    'label' => 'Raised',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-500 text-white shadow-md shadow-blue-500/25',
    'green' => 'bg-green-500 text-white shadow-md shadow-green-500/25',
    'red' => 'bg-red-500 text-white shadow-md shadow-red-500/25',
    'yellow' => 'bg-yellow-500 text-white shadow-md shadow-yellow-500/25',
    'purple' => 'bg-purple-500 text-white shadow-md shadow-purple-500/25',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-md', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
