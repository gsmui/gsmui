@props([
    'color' => 'blue',
    'speed' => '3s',
])

@php
$colors = [
    'blue' => 'from-blue-500 via-purple-500 to-blue-500',
    'green' => 'from-green-500 via-cyan-500 to-green-500',
    'pink' => 'from-pink-500 via-red-500 to-pink-500',
    'rainbow' => 'from-red-500 via-yellow-500 via-green-500 via-blue-500 to-purple-500',
];

$colorClass = $colors[$color] ?? 'from-blue-500 via-purple-500 to-blue-500';
@endphp

<div class="relative p-[2px] rounded-xl overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r {{ $colorClass }} animate-spin" style="animation-duration: {{ $speed }};"></div>
    <div class="relative bg-white dark:bg-zinc-900 rounded-[10px] m-[1px]">
        {{ $slot }}
    </div>
</div>
