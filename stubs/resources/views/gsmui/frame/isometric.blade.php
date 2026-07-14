@props([
    'angle' => '45',
    'depth' => '20',
    'color' => 'blue',
])

@php
$colors = [
    'blue' => ['top' => 'bg-blue-400', 'left' => 'bg-blue-600', 'right' => 'bg-blue-500'],
    'green' => ['top' => 'bg-green-400', 'left' => 'bg-green-600', 'right' => 'bg-green-500'],
    'purple' => ['top' => 'bg-purple-400', 'left' => 'bg-purple-600', 'right' => 'bg-purple-500'],
];

$colorData = $colors[$color] ?? $colors['blue'];
@endphp

<div class="relative" style="transform: rotateX({{ $angle }}deg) rotateY({{ $angle }}deg); transform-style: preserve-3d;">
    <div class="relative z-10">
        {{ $slot }}
    </div>
</div>
