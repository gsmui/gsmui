@props([
    'gradient' => 'blue-purple',
    'padding' => true,
    'animated' => false,
])

@php
$gradients = [
    'blue-purple' => 'from-blue-500 to-purple-500',
    'green-blue' => 'from-green-500 to-blue-500',
    'orange-red' => 'from-orange-500 to-red-500',
    'pink-purple' => 'from-pink-500 to-purple-500',
    'yellow-orange' => 'from-yellow-500 to-orange-500',
    'rainbow' => 'from-red-500 via-yellow-500 via-green-500 to-blue-500',
];

$gradientClass = $gradients[$gradient] ?? 'from-blue-500 to-purple-500';
@endphp

<div {{ $attributes->class(['relative rounded-xl p-[2px]', $animated ? 'bg-gradient-to-r bg-[length:200%_auto] animate-gradient' : "bg-gradient-to-r {$gradientClass}"]) }}>
    <div class="bg-white dark:bg-zinc-900 rounded-[10px] {{ $padding ? 'p-4' : '' }}">
        {{ $slot }}
    </div>
</div>
