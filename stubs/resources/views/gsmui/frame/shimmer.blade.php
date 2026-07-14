@props([
    'color' => 'white',
    'speed' => '2s',
])

@php
$colors = [
    'white' => 'from-transparent via-white/30 to-transparent',
    'blue' => 'from-transparent via-blue-500/30 to-transparent',
    'purple' => 'from-transparent via-purple-500/30 to-transparent',
];

$colorClass = $colors[$color] ?? 'from-transparent via-white/30 to-transparent';
@endphp

<div class="relative overflow-hidden rounded-xl">
    {{ $slot }}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-r {{ $colorClass }} -translate-x-full animate-shimmer" style="animation-duration: {{ $speed }};"></div>
    </div>
</div>
