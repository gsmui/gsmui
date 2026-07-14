@props([
    'color' => 'blue',
    'speed' => '2s',
])

@php
$colors = [
    'blue' => 'border-blue-500',
    'green' => 'border-green-500',
    'purple' => 'border-purple-500',
    'red' => 'border-red-500',
];

$colorClass = $colors[$color] ?? 'border-blue-500';
@endphp

<div {{ $attributes->class([
    'rounded-xl border-2',
    $colorClass,
    'animate-pulse',
]) }} style="animation-duration: {{ $speed }};">
    {{ $slot }}
</div>
