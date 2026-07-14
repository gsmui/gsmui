@props([
    'label' => 'Status',
    'status' => 'active',
    'size' => 'md',
])

@php
$statuses = [
    'active' => ['dot' => 'bg-green-500', 'text' => 'text-green-700 dark:text-green-400', 'bg' => 'bg-green-50 dark:bg-green-900/20'],
    'inactive' => ['dot' => 'bg-zinc-400', 'text' => 'text-zinc-600 dark:text-zinc-400', 'bg' => 'bg-zinc-50 dark:bg-zinc-800'],
    'pending' => ['dot' => 'bg-yellow-500', 'text' => 'text-yellow-700 dark:text-yellow-400', 'bg' => 'bg-yellow-50 dark:bg-yellow-900/20'],
    'error' => ['dot' => 'bg-red-500', 'text' => 'text-red-700 dark:text-red-400', 'bg' => 'bg-red-50 dark:bg-red-900/20'],
];
$statusSet = $statuses[$status] ?? $statuses['active'];

$sizes = [
    'sm' => ['dot' => 'w-1.5 h-1.5', 'text' => 'text-xs', 'padding' => 'px-2 py-0.5'],
    'md' => ['dot' => 'w-2 h-2', 'text' => 'text-sm', 'padding' => 'px-2.5 py-1'],
    'lg' => ['dot' => 'w-2.5 h-2.5', 'text' => 'text-base', 'padding' => 'px-3 py-1.5'],
];
$sizeSet = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class([
    'inline-flex items-center gap-1.5 rounded-full',
    $statusSet['bg'],
    $sizeSet['padding'],
]) }}>
    <span class="rounded-full {{ $statusSet['dot'] }} {{ $sizeSet['dot'] }}"></span>
    <span class="font-medium {{ $statusSet['text'] }} {{ $sizeSet['text'] }}">{{ $label }}</span>
</div>
