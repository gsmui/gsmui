@props([
    'crosshair' => true,
    'color' => 'red',
])

@php
$colors = [
    'red' => 'border-red-500',
    'green' => 'border-green-500',
    'blue' => 'border-blue-500',
    'white' => 'border-white',
];

$colorClass = $colors[$color] ?? 'border-red-500';
@endphp

<div class="relative inline-block">
    <div {{ $attributes->class([
        'rounded-full overflow-hidden',
        'border-8',
        $colorClass,
        'shadow-xl',
    ]) }}>
        {{ $slot }}
    </div>
    
    @if($crosshair)
    {{-- Crosshair --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/2 left-0 right-0 h-px {{ $colorClass }} bg-current opacity-50"></div>
        <div class="absolute left-1/2 top-0 bottom-0 w-px {{ $colorClass }} bg-current opacity-50"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 rounded-full border {{ $colorClass }}"></div>
    </div>
    @endif
</div>
