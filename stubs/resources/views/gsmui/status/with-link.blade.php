@props([
    'label' => 'Status',
    'href' => '#',
    'linkText' => 'View details',
    'status' => 'info',
])

@php
$statuses = [
    'success' => 'text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300',
    'error' => 'text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300',
    'warning' => 'text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300',
    'info' => 'text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300',
];
$colorClass = $statuses[$status] ?? $statuses['info'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2 text-sm']) }}>
    <span class="text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    <a href="{{ $href }}" class="font-medium underline underline-offset-2 {{ $colorClass }}">{{ $linkText }}</a>
</div>
