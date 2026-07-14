@props([
    'label' => 'Side A',
    'color' => 'zinc',
])

@php
$colors = [
    'zinc' => 'bg-zinc-300 border-zinc-400',
    'black' => 'bg-zinc-800 border-zinc-900',
    'white' => 'bg-stone-100 border-stone-200',
];

$colorClass = $colors[$color] ?? 'bg-zinc-300';
@endphp

<div {{ $attributes->class([
    'rounded-lg border-2',
    $colorClass,
    'p-3 shadow-lg',
]) }}>
    {{-- Label area --}}
    <div class="bg-white dark:bg-zinc-100 rounded px-3 py-1 text-center mb-2">
        <p class="text-xs font-bold text-zinc-800 uppercase tracking-widest">{{ $label }}</p>
    </div>
    
    {{-- Tape reels --}}
    <div class="flex justify-between items-center px-4">
        <div class="w-12 h-12 rounded-full bg-zinc-800 border-4 border-zinc-600 flex items-center justify-center">
            <div class="w-4 h-4 rounded-full bg-zinc-400"></div>
        </div>
        <div class="w-16 h-8 bg-zinc-800 rounded"></div>
        <div class="w-12 h-12 rounded-full bg-zinc-800 border-4 border-zinc-600 flex items-center justify-center">
            <div class="w-4 h-4 rounded-full bg-zinc-400"></div>
        </div>
    </div>
    
    {{-- Content area --}}
    <div class="mt-3 bg-zinc-100 dark:bg-zinc-200 rounded overflow-hidden">
        {{ $slot }}
    </div>
</div>
