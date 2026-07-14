@props([
    'minutes' => 0,
    'seconds' => 0,
    'status' => 'info',
    'size' => 'md',
])

@php
$defaultColors = [
    'success' => 'bg-green-500',
    'error' => 'bg-red-500',
    'warning' => 'bg-yellow-500',
    'info' => 'bg-blue-500',
];

$sizes = [
    'sm' => 'text-xs px-2 py-0.5',
    'md' => 'text-sm px-2.5 py-1',
    'lg' => 'text-base px-3 py-1.5',
];

$colorClass = $defaultColors[$status] ?? 'bg-zinc-500';
$sizeClass = $sizes[$size] ?? 'text-sm px-2.5 py-1';

$time = sprintf('%02d:%02d', $minutes, $seconds);
@endphp

<span {{ $attributes->class(['inline-flex items-center gap-1.5 rounded-full font-mono tabular-nums', $sizeClass, $colorClass, 'text-white']) }}>
    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    {{ $time }}
</span>
