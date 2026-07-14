@props([
    'strength' => 3,
    'max' => 4,
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
    'sm' => 'h-3',
    'md' => 'h-4',
    'lg' => 'h-5',
];

$colorClass = $defaultColors[$status] ?? 'bg-zinc-500';
$sizeClass = $sizes[$size] ?? 'h-4';
@endphp

<div {{ $attributes->class(['inline-flex items-end gap-0.5']) }}>
    @for($i = 1; $i <= $max; $i++)
        <div @class([
            'rounded-sm',
            $sizeClass,
            'w-1',
            $i <= $strength ? $colorClass : 'bg-zinc-200 dark:bg-zinc-700',
        ]) style="height: {{ 40 + ($i * 15) }}%"></div>
    @endfor
</div>
