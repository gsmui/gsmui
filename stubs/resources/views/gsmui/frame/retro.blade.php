@props([
    'style' => 'vintage',
    'color' => 'amber',
])

@php
$styles = [
    'vintage' => 'border-4 border-double',
    'polaroid' => 'bg-white dark:bg-zinc-800 p-4 pb-12',
    'newspaper' => 'border-4 border-zinc-900',
    'comic' => 'border-4 border-black rounded-none',
];

$colors = [
    'amber' => 'border-amber-700 bg-amber-50',
    'sepia' => 'border-amber-900 bg-amber-100',
    'green' => 'border-green-700 bg-green-50',
];

$styleClass = $styles[$style] ?? 'border-4 border-double';
$colorClass = $colors[$color] ?? 'border-amber-700 bg-amber-50';
@endphp

<div {{ $attributes->class([
    $styleClass,
    $colorClass,
    'shadow-lg',
]) }}>
    {{ $slot }}
</div>
