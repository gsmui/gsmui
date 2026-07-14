@props([
    'direction' => 'N',
    'degrees' => 0,
    'size' => 'md',
    'color' => 'blue',
])

@php
$directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];
$dirIndex = array_search(strtoupper($direction), $directions);
$degrees = $dirIndex !== false ? $dirIndex * 45 : $degrees;

$colors = [
    'blue' => 'text-blue-500',
    'green' => 'text-green-500',
    'red' => 'text-red-500',
    'zinc' => 'text-zinc-500',
];

$sizes = [
    'sm' => 'h-8 w-8',
    'md' => 'h-10 w-10',
    'lg' => 'h-12 w-12',
];

$colorClass = $colors[$color] ?? 'text-blue-500';
$sizeClass = $sizes[$size] ?? 'h-10 w-10';
@endphp

<div {{ $attributes->class(['inline-flex flex-col items-center gap-0.5']) }}>
    <svg viewBox="0 0 24 24" fill="currentColor" class="{{ $sizeClass }} {{ $colorClass }}" style="transform: rotate({{ $degrees }}deg)">
        <path d="M12 2l-5 20h3l2-8 2 8h3L12 2z"/>
    </svg>
    <span class="text-[10px] font-semibold text-zinc-500 dark:text-zinc-400">{{ $direction }}</span>
</div>
