@props([
    'color' => 'blue',
    'position' => 'left',
])

@php
$colors = [
    'blue' => 'bg-blue-500',
    'red' => 'bg-red-500',
    'green' => 'bg-green-500',
    'purple' => 'bg-purple-500',
];

$positions = [
    'left' => 'left-4',
    'center' => 'left-1/2 -translate-x-1/2',
    'right' => 'right-4',
];

$colorClass = $colors[$color] ?? 'bg-blue-500';
$positionClass = $positions[$position] ?? 'left-4';
@endphp

<div class="relative inline-block">
    {{-- Pin --}}
    <div class="absolute -top-1 {{ $positionClass }} w-3 h-3 bg-zinc-400 rounded-full shadow"></div>
    
    <div {{ $attributes->class([
        'bg-white dark:bg-zinc-800 dark:bg-zinc-800 rounded-lg shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 dark:border-zinc-700',
    ]) }}>
        {{-- Header --}}
        <div class="{{ $colorClass }} px-4 py-2 text-white text-xs font-bold uppercase tracking-wider text-center">
            Hello
        </div>
        {{-- Content --}}
        <div class="p-4">
            {{ $slot }}
        </div>
    </div>
</div>
