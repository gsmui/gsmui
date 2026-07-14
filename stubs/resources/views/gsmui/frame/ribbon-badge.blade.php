@props([
    'text' => '',
    'color' => 'red',
    'position' => 'top-right',
])

@php
$colors = [
    'red' => 'bg-red-500',
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
    'amber' => 'bg-amber-500',
];

$colorClass = $colors[$color] ?? 'bg-red-500';
@endphp

<div class="relative inline-block">
    {{ $slot }}
    
    @if($text)
    <div class="absolute {{ $position === 'top-right' ? 'top-0 right-0' : 'bottom-0 left-0' }} overflow-hidden">
        <div class="{{ $colorClass }} text-white text-xs font-bold px-4 py-1 shadow-lg"
             style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%, 10px 50%);">
            {{ $text }}
        </div>
    </div>
    @endif
</div>
