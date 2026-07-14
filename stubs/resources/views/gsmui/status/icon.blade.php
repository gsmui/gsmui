@props([
    'icon' => '✓',
    'status' => 'success',
    'size' => 'md',
    'label' => '',
])

@php
$statuses = [
    'success' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-600 dark:text-green-400', 'icon' => '✓'],
    'error' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-600 dark:text-red-400', 'icon' => '✕'],
    'warning' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-600 dark:text-yellow-400', 'icon' => '⚠'],
    'info' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-600 dark:text-blue-400', 'icon' => 'ℹ'],
    'pending' => ['bg' => 'bg-zinc-100 dark:bg-zinc-800', 'text' => 'text-zinc-600 dark:text-zinc-400', 'icon' => '⏳'],
];
$statusSet = $statuses[$status] ?? $statuses['success'];

$sizes = [
    'sm' => 'w-6 h-6 text-xs',
    'md' => 'w-8 h-8 text-sm',
    'lg' => 'w-10 h-10 text-base',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-1.5 group']) }}>
    <div class="inline-flex items-center justify-center rounded-full {{ $sizeClass }} {{ $statusSet['bg'] }} {{ $statusSet['text'] }}">
        {{ $icon ?? $statusSet['icon'] }}
    </div>
    
    @if($label)
        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    @endif
</div>
