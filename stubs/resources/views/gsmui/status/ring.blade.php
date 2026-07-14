@props([
    'label' => 'Status',
    'status' => 'online',
    'size' => 'md',
])

@php
$statuses = [
    'online' => ['ring' => 'ring-green-500', 'bg' => 'bg-green-500', 'text' => 'text-green-700 dark:text-green-400'],
    'offline' => ['ring' => 'ring-zinc-400', 'bg' => 'bg-zinc-400', 'text' => 'text-zinc-600 dark:text-zinc-400'],
    'away' => ['ring' => 'ring-yellow-500', 'bg' => 'bg-yellow-500', 'text' => 'text-yellow-700 dark:text-yellow-400'],
    'busy' => ['ring' => 'ring-red-500', 'bg' => 'bg-red-500', 'text' => 'text-red-700 dark:text-red-400'],
];
$statusSet = $statuses[$status] ?? $statuses['online'];

$sizes = [
    'sm' => 'ring-2 text-xs px-2 py-0.5',
    'md' => 'ring-2 text-sm px-2.5 py-1',
    'lg' => 'ring-4 text-base px-3 py-1.5',
];
$sizeSet = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class([
    'inline-flex items-center gap-1.5 rounded-full bg-white dark:bg-zinc-900',
    $sizeSet,
    $statusSet['ring'],
]) }}>
    <span class="w-2 h-2 rounded-full {{ $statusSet['bg'] }}"></span>
    <span class="font-medium {{ $statusSet['text'] }}">{{ $label }}</span>
</div>
