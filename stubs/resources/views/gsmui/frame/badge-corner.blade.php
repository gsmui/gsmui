@props([
    'badge' => '',
    'position' => 'top-right',
    'color' => 'red',
])

@php
$positions = [
    'top-right' => 'top-2 right-2',
    'top-left' => 'top-2 left-2',
    'bottom-right' => 'bottom-2 right-2',
    'bottom-left' => 'bottom-2 left-2',
];

$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'red' => 'bg-red-500',
];

$positionClass = $positions[$position] ?? 'top-2 right-2';
$colorClass = $colors[$color] ?? 'bg-red-500';
@endphp

<div class="relative inline-block">
    {{ $slot }}
    
    @if($badge)
    <span class="absolute {{ $positionClass }} {{ $colorClass }} text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-lg z-10">
        {{ $badge }}
    </span>
    @endif
</div>
