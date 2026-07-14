@props([
    'label' => 'Updated',
    'timestamp' => null,
    'status' => 'success',
    'size' => 'md',
])

@php
$statuses = [
    'success' => 'text-green-600 dark:text-green-400',
    'error' => 'text-red-600 dark:text-red-400',
    'warning' => 'text-yellow-600 dark:text-yellow-400',
    'info' => 'text-blue-600 dark:text-blue-400',
];
$colorClass = $statuses[$status] ?? $statuses['success'];
$displayTime = $timestamp ? \Carbon\Carbon::parse($timestamp)->diffForHumans() : 'Just now';
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2 text-sm']) }}>
    <span class="font-medium {{ $colorClass }}">{{ $label }}</span>
    <span class="text-zinc-400 dark:text-zinc-500">·</span>
    <span class="text-zinc-500 dark:text-zinc-400">{{ $displayTime }}</span>
</div>
