@props([
    'label' => 'Shadow',
    'color' => 'blue',
    'size' => 'md',
])

@php
$colors = [
    'blue' => 'bg-blue-500 text-white shadow-[0_4px_14px_0_rgba(59,130,246,0.39)]',
    'green' => 'bg-green-500 text-white shadow-[0_4px_14px_0_rgba(34,197,94,0.39)]',
    'red' => 'bg-red-500 text-white shadow-[0_4px_14px_0_rgba(239,68,68,0.39)]',
    'purple' => 'bg-purple-500 text-white shadow-[0_4px_14px_0_rgba(168,85,247,0.39)]',
];
$colorClass = $colors[$color] ?? $colors['blue'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-full', $colorClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
