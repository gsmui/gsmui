@props([
    'label' => 'Large',
    'status' => 'success',
    'description' => 'Large status with description',
    'showIcon' => true,
])

@php
$statuses = [
    'success' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-700 dark:text-green-400', 'icon' => '✓', 'iconColor' => 'text-green-500'],
    'error' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-700 dark:text-red-400', 'icon' => '✕', 'iconColor' => 'text-red-500'],
    'warning' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400', 'icon' => '⚠', 'iconColor' => 'text-yellow-500'],
    'info' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400', 'icon' => 'ℹ', 'iconColor' => 'text-blue-500'],
];
$statusSet = $statuses[$status] ?? $statuses['success'];
@endphp

<div {{ $attributes->class(['flex items-center gap-4 p-5 rounded-xl', $statusSet['bg']]) }}>
    @if($showIcon)
        <div class="w-12 h-12 rounded-full bg-white dark:bg-zinc-800 flex items-center justify-center shadow-sm">
            <span class="text-2xl {{ $statusSet['iconColor'] }}">{{ $statusSet['icon'] }}</span>
        </div>
    @endif
    <div>
        <span class="text-lg font-semibold {{ $statusSet['text'] }}">{{ $label }}</span>
        @if($description)
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-0.5">{{ $description }}</p>
        @endif
    </div>
</div>
