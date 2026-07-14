@props([
    'color' => 'blue',
    'speed' => '3s',
])

@php
$colors = [
    'blue' => 'shadow-blue-500/50',
    'green' => 'shadow-green-500/50',
    'purple' => 'shadow-purple-500/50',
    'pink' => 'shadow-pink-500/50',
];

$colorClass = $colors[$color] ?? 'shadow-blue-500/50';
@endphp

<div {{ $attributes->class([
    'rounded-xl shadow-lg',
    $colorClass,
    'animate-breathing',
]) }} style="animation-duration: {{ $speed }};">
    {{ $slot }}
</div>
