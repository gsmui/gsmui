@props([
    'clip' => true,
    'color' => 'zinc',
])

@php
$colors = [
    'zinc' => 'bg-zinc-200 dark:bg-zinc-700 border-zinc-300 dark:border-zinc-600',
    'brown' => 'bg-amber-200 dark:bg-amber-800 border-amber-300 dark:border-amber-700',
];

$colorClass = $colors[$color] ?? 'bg-zinc-200';
@endphp

<div class="relative">
    @if($clip)
    {{-- Clip --}}
    <div class="absolute -top-3 left-1/2 -translate-x-1/2 z-10">
        <div class="w-16 h-8 bg-zinc-400 dark:bg-zinc-500 rounded-t-lg border-t-2 border-l-2 border-r-2 border-zinc-500 dark:border-zinc-400"></div>
        <div class="w-8 h-4 bg-zinc-500 dark:bg-zinc-600 rounded-b-lg mx-auto -mt-1"></div>
    </div>
    @endif
    
    <div {{ $attributes->class([
        'rounded-lg shadow-xl',
        $colorClass,
        $clip ? 'pt-4' : '',
    ]) }}>
        <div class="bg-white dark:bg-zinc-900 m-3 rounded shadow-inner">
            {{ $slot }}
        </div>
    </div>
</div>
