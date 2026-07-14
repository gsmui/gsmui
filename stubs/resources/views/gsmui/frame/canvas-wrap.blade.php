@props([
    'depth' => 'md',
    'color' => 'white',
])

@php
$depths = [
    'sm' => 'shadow-[4px_4px_8px_rgba(0,0,0,0.15)]',
    'md' => 'shadow-[8px_8px_16px_rgba(0,0,0,0.2)]',
    'lg' => 'shadow-[12px_12px_24px_rgba(0,0,0,0.25)]',
];

$colors = [
    'white' => 'bg-white',
    'black' => 'bg-zinc-900',
    'wood' => 'bg-amber-800',
];

$depthClass = $depths[$depth] ?? 'shadow-[8px_8px_16px_rgba(0,0,0,0.2)]';
$colorClass = $colors[$color] ?? 'bg-white';
@endphp

<div class="relative">
    <div {{ $attributes->class([
        $depthClass,
        'rounded-sm overflow-hidden',
    ]) }}>
        <div class="bg-zinc-100 dark:bg-zinc-800 p-2">
            {{ $slot }}
        </div>
    </div>
</div>
