@props([
    'color' => 'blue',
    'speed' => '2s',
])

@php
$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
];

$colorClass = $colors[$color] ?? 'bg-blue-500';
@endphp

<div class="relative overflow-hidden rounded-xl">
    {{ $slot }}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-x-0 h-[2px] {{ $colorClass }} opacity-50 animate-scan" style="animation-duration: {{ $speed }};"></div>
    </div>
</div>
