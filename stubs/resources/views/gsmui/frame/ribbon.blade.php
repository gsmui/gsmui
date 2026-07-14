@props([
    'text' => '',
    'position' => 'top-right',
    'color' => 'red',
])

@php
$positions = [
    'top-right' => 'top-4 right-0 translate-x-2 rotate-45',
    'top-left' => 'top-4 left-0 -translate-x-2 -rotate-45',
    'bottom-right' => 'bottom-4 right-0 translate-x-2 -rotate-45',
    'bottom-left' => 'bottom-4 left-0 -translate-x-2 rotate-45',
];

$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'red' => 'bg-red-500',
    'amber' => 'bg-amber-500',
];

$positionClass = $positions[$position] ?? 'top-4 right-0 translate-x-2 rotate-45';
$colorClass = $colors[$color] ?? 'bg-red-500';
@endphp

<div class="relative overflow-hidden rounded-xl">
    {{ $slot }}
    
    @if($text)
    <div class="absolute {{ $positionClass }} {{ $colorClass }} text-white text-xs font-bold px-8 py-1 shadow-lg z-10">
        {{ $text }}
    </div>
    @endif
</div>
