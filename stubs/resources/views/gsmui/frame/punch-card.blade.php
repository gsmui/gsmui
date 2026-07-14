@props([
    'holes' => true,
    'color' => 'zinc',
])

@php
$colors = [
    'zinc' => 'bg-zinc-200 dark:bg-zinc-700 border-zinc-300 dark:border-zinc-600',
    'white' => 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700',
    'manila' => 'bg-amber-100 border-amber-200',
];

$colorClass = $colors[$color] ?? 'bg-zinc-200';
@endphp

<div {{ $attributes->class([
    'relative rounded shadow-lg',
    $colorClass,
    'border',
]) }}>
    @if($holes)
    {{-- Punch holes --}}
    <div class="absolute left-0 top-0 bottom-0 w-8 flex flex-col justify-around py-2">
        @for($i = 1; $i <= 5; $i++)
        <div class="w-3 h-3 rounded-full bg-white dark:bg-zinc-800 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600 mx-auto"></div>
        @endfor
    </div>
    @endif
    
    <div class="{{ $holes ? 'ml-10' : '' }} p-4">
        {{ $slot }}
    </div>
</div>
