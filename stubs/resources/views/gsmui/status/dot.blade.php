@props([
    'status' => 'online',
    'size' => 'md',
    'pulse' => false,
])

@php
$statuses = [
    'online' => 'bg-green-500',
    'offline' => 'bg-zinc-400',
    'away' => 'bg-yellow-500',
    'busy' => 'bg-red-500',
    'dnd' => 'bg-red-500',
    'idle' => 'bg-orange-500',
];
$colorClass = $statuses[$status] ?? 'bg-zinc-400';

$sizes = [
    'xs' => 'w-1.5 h-1.5',
    'sm' => 'w-2 h-2',
    'md' => 'w-2.5 h-2.5',
    'lg' => 'w-3 h-3',
    'xl' => 'w-4 h-4',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class([
    'inline-flex items-center justify-center rounded-full',
    $sizeClass,
    $colorClass,
    $pulse ? 'animate-pulse' : '',
]) }}>
    @if($pulse)
        <span class="absolute inline-flex rounded-full {{ $sizeClass }} {{ $colorClass }} animate-ping opacity-75"></span>
    @endif
</div>
