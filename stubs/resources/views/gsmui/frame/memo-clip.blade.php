@props([
    'color' => 'silver',
    'rotation' => 0,
])

@php
$colors = [
    'silver' => 'bg-zinc-300 border-zinc-400',
    'gold' => 'bg-amber-300 border-amber-400',
    'black' => 'bg-zinc-800 border-zinc-900',
];

$colorClass = $colors[$color] ?? 'bg-zinc-300';
@endphp

<div class="relative inline-block" style="transform: rotate({{ $rotation }}deg);">
    {{-- Clip --}}
    <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-20">
        <div class="w-8 h-12 {{ $colorClass }} border-2 rounded-t-lg"></div>
        <div class="w-6 h-3 {{ $colorClass }} border-2 border-t-0 rounded-b-lg mx-auto -mt-1"></div>
    </div>
    
    {{-- Paper --}}
    <div class="relative z-10 bg-white dark:bg-zinc-800 dark:bg-zinc-800 rounded shadow-lg p-4 mt-4">
        {{ $slot }}
    </div>
</div>
