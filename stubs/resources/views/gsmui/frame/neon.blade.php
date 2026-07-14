@props([
    'color' => 'blue',
    'intensity' => 'md',
    'animated' => false,
])

@php
$colors = [
    'blue' => ['shadow' => 'shadow-blue-500/50', 'border' => 'border-blue-500', 'glow' => '0 0 20px rgba(59, 130, 246, 0.5)'],
    'green' => ['shadow' => 'shadow-green-500/50', 'border' => 'border-green-500', 'glow' => '0 0 20px rgba(34, 197, 94, 0.5)'],
    'purple' => ['shadow' => 'shadow-purple-500/50', 'border' => 'border-purple-500', 'glow' => '0 0 20px rgba(168, 85, 247, 0.5)'],
    'pink' => ['shadow' => 'shadow-pink-500/50', 'border' => 'border-pink-500', 'glow' => '0 0 20px rgba(236, 72, 153, 0.5)'],
    'cyan' => ['shadow' => 'shadow-cyan-500/50', 'border' => 'border-cyan-500', 'glow' => '0 0 20px rgba(6, 182, 212, 0.5)'],
];

$colorData = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class([
    'rounded-xl border-2',
    $colorData['border'],
    $animated ? 'animate-pulse' : '',
]) }} style="box-shadow: {{ $colorData['glow'] }};">
    {{ $slot }}
</div>
