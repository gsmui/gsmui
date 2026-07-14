@props([
    'label' => 'Block',
    'description' => 'Block status description',
    'status' => 'info',
    'size' => 'md',
    'icon' => null,
])

@php
$statuses = [
    'success' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-200 dark:border-green-800', 'icon' => '✓', 'iconColor' => 'text-green-500', 'text' => 'text-green-800 dark:text-green-300'],
    'error' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-red-200 dark:border-red-800', 'icon' => '✕', 'iconColor' => 'text-red-500', 'text' => 'text-red-800 dark:text-red-300'],
    'warning' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'border' => 'border-yellow-200 dark:border-yellow-800', 'icon' => '⚠', 'iconColor' => 'text-yellow-500', 'text' => 'text-yellow-800 dark:text-yellow-300'],
    'info' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-800', 'icon' => 'ℹ', 'iconColor' => 'text-blue-500', 'text' => 'text-blue-800 dark:text-blue-300'],
];
$statusSet = $statuses[$status] ?? $statuses['info'];
@endphp

<div {{ $attributes->class(['flex items-start gap-3 p-4 rounded-lg border', $statusSet['bg'], $statusSet['border']]) }}>
    <span class="text-lg {{ $statusSet['iconColor'] }}">{{ $icon ?? $statusSet['icon'] }}</span>
    <div>
        <span class="font-medium {{ $statusSet['text'] }}">{{ $label }}</span>
        @if($description)
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-0.5">{{ $description }}</p>
        @endif
    </div>
</div>
