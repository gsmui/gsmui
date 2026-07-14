@props([
    'color' => 'yellow',
    'rotation' => 0,
])

@php
$colors = [
    'yellow' => 'bg-yellow-200 dark:bg-yellow-900/50',
    'pink' => 'bg-pink-200 dark:bg-pink-900/50',
    'green' => 'bg-green-200 dark:bg-green-900/50',
    'blue' => 'bg-blue-200 dark:bg-blue-900/50',
    'purple' => 'bg-purple-200 dark:bg-purple-900/50',
];

$colorClass = $colors[$color] ?? 'bg-yellow-200';
@endphp

<div {{ $attributes->class([
    $colorClass,
    'p-4 rounded-sm shadow-lg',
    'rotate-[' . $rotation . 'deg]',
    'hover:rotate-0 transition-transform duration-300',
]) }}>
    {{-- Tape effect --}}
    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-12 h-4 bg-white dark:bg-zinc-800/50 dark:bg-white dark:bg-zinc-800/20 rounded-sm"></div>
    {{ $slot }}
</div>
