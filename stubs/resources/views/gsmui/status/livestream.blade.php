@props([
    'isLive' => true,
    'label' => 'LIVE',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'h-5 px-1.5 text-[10px] gap-1',
    'md' => 'h-6 px-2 text-xs gap-1.5',
    'lg' => 'h-7 px-2.5 text-sm gap-1.5',
];

$dotSizes = [
    'sm' => 'h-1.5 w-1.5',
    'md' => 'h-2 w-2',
    'lg' => 'h-2.5 w-2.5',
];

$sizeClass = $sizes[$size] ?? 'h-6 px-2 text-xs gap-1.5';
$dotSize = $dotSizes[$size] ?? 'h-2 w-2';
@endphp

<span @class([
    'inline-flex items-center rounded-full font-bold uppercase tracking-wider',
    $sizeClass,
    $isLive ? 'bg-red-500 text-white' : 'bg-zinc-200 text-zinc-500 dark:bg-zinc-700 dark:text-zinc-400',
]) {{ $attributes }}>
    @if($isLive)
        <span class="{{ $dotSize }} rounded-full bg-white animate-pulse"></span>
    @endif
    {{ $label }}
</span>
