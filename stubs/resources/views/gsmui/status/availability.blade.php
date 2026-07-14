@props([
    'days' => [],
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'h-2 w-2 gap-0.5',
    'md' => 'h-2.5 w-2.5 gap-1',
    'lg' => 'h-3 w-3 gap-1.5',
];

$sizeClass = $sizes[$size] ?? 'h-2.5 w-2.5 gap-1';

// Default 7 days of the week
$weekdays = $days ?: ['M', 'T', 'W', 'T', 'F', 'S', 'S'];
@endphp

<div {{ $attributes->class(['inline-flex items-center', $sizeClass]) }}>
    @foreach($weekdays as $day => $available)
        <span @class([
            'rounded-full',
            $sizeClass,
            $available ? 'bg-green-500' : 'bg-zinc-200 dark:bg-zinc-700',
        ])></span>
    @endforeach
</div>
