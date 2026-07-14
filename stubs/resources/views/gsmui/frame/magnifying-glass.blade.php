@props([
    'size' => 'md',
    'color' => 'zinc',
])

@php
$sizes = [
    'sm' => 'w-32 h-32',
    'md' => 'w-48 h-48',
    'lg' => 'w-64 h-64',
];

$colors = [
    'zinc' => 'bg-zinc-300 border-zinc-400',
    'blue' => 'bg-blue-300 border-blue-400',
    'green' => 'bg-green-300 border-green-400',
];

$sizeClass = $sizes[$size] ?? 'w-48 h-48';
$colorClass = $colors[$color] ?? 'bg-zinc-300';
@endphp

<div class="relative inline-block">
    <div {{ $attributes->class([
        'rounded-full',
        $sizeClass,
        'bg-white dark:bg-zinc-800/80 dark:bg-zinc-800/80',
        'border-8',
        $colorClass,
        'shadow-xl overflow-hidden',
    ]) }}>
        {{ $slot }}
    </div>
    {{-- Handle --}}
    <div class="absolute -bottom-8 -right-4 w-20 h-4 bg-gradient-to-r from-zinc-400 to-zinc-500 rounded-full transform rotate-45"></div>
</div>
