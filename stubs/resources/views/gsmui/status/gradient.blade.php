@props([
    'label' => 'Gradient',
    'gradient' => 'blue-purple',
    'size' => 'md',
])

@php
$gradients = [
    'blue-purple' => 'bg-gradient-to-r from-blue-500 to-purple-500 text-white',
    'green-teal' => 'bg-gradient-to-r from-green-500 to-teal-500 text-white',
    'orange-red' => 'bg-gradient-to-r from-orange-500 to-red-500 text-white',
    'pink-purple' => 'bg-gradient-to-r from-pink-500 to-purple-500 text-white',
    'indigo-blue' => 'bg-gradient-to-r from-indigo-500 to-blue-500 text-white',
];
$gradientClass = $gradients[$gradient] ?? $gradients['blue-purple'];
$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-md', $gradientClass, $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
