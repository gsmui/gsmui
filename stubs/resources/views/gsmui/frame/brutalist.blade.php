@props([
    'shadow' => 'offset',
    'color' => 'black',
])

@php
$shadows = [
    'offset' => 'translate-x-2 translate-y-2',
    'large-offset' => 'translate-x-4 translate-y-4',
    'none' => '',
];

$colors = [
    'black' => 'border-black bg-white dark:bg-zinc-800',
    'blue' => 'border-blue-500 bg-white dark:bg-zinc-800',
    'red' => 'border-red-500 bg-white dark:bg-zinc-800',
    'green' => 'border-green-500 bg-white dark:bg-zinc-800',
];

$shadowClass = $shadows[$shadow] ?? 'translate-x-2 translate-y-2';
$colorClass = $colors[$color] ?? 'border-black bg-white dark:bg-zinc-800';
@endphp

<div class="relative">
    @if($shadow !== 'none')
    <div class="absolute inset-0 {{ $shadowClass }} bg-black border-2 border-black"></div>
    @endif
    <div {{ $attributes->class([
        'relative border-2',
        $colorClass,
    ]) }}>
        {{ $slot }}
    </div>
</div>
