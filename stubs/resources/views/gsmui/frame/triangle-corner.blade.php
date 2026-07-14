@props([
    'position' => 'bottom-right',
    'color' => 'blue',
    'size' => '32',
])

@php
$positions = [
    'bottom-right' => 'bottom-0 right-0',
    'bottom-left' => 'bottom-0 left-0',
    'top-right' => 'top-0 right-0',
    'top-left' => 'top-0 left-0',
];

$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'red' => 'bg-red-500',
];

$positionClass = $positions[$position] ?? 'bottom-0 right-0';
$colorClass = $colors[$color] ?? 'bg-blue-500';
@endphp

<div class="relative overflow-hidden rounded-xl">
    {{ $slot }}
    <div class="absolute {{ $positionClass }} w-0 h-0 border-solid {{ $colorClass }}"
         style="border-width: 0 0 {{ $size }}px {{ $size }}px; border-color: transparent transparent {{ $colorClass }} transparent;"></div>
</div>
