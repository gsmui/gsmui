@props([
    'label' => 'Click me',
    'color' => 'blue',
    'size' => 'md',
    'href' => '#',
])

@php
$colors = [
    'blue' => 'bg-blue-500 text-white hover:bg-blue-600',
    'green' => 'bg-green-500 text-white hover:bg-green-600',
    'red' => 'bg-red-500 text-white hover:bg-red-600',
    'yellow' => 'bg-yellow-500 text-white hover:bg-yellow-600',
    'purple' => 'bg-purple-500 text-white hover:bg-purple-600',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<a href="{{ $href }}" {{ $attributes->class(['inline-flex items-center font-medium rounded-md cursor-pointer transition-colors', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</a>
