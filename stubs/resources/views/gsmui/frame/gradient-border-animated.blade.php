@props([
    'gradient' => 'blue-purple',
    'speed' => '3s',
    'thickness' => '2',
])

@php
$gradients = [
    'blue-purple' => 'from-blue-500 via-purple-500 to-blue-500',
    'green-blue' => 'from-green-500 via-cyan-500 to-green-500',
    'pink-orange' => 'from-pink-500 via-orange-500 to-pink-500',
    'rainbow' => 'from-red-500 via-yellow-500 via-green-500 via-blue-500 to-purple-500',
];

$gradientClass = $gradients[$gradient] ?? 'from-blue-500 via-purple-500 to-blue-500';
@endphp

<div class="relative p-[{{ $thickness }}px] rounded-xl overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r {{ $gradientClass }} bg-[length:200%_100%] animate-gradient" 
         style="animation-duration: {{ $speed }};"></div>
    <div class="relative bg-white dark:bg-zinc-900 rounded-[10px]">
        {{ $slot }}
    </div>
</div>
