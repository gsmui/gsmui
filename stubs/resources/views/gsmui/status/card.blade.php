@props([
    'label' => 'Card Status',
    'description' => 'Card with status indicator',
    'status' => 'active',
    'size' => 'md',
])

@php
$statuses = [
    'active' => ['dot' => 'bg-green-500', 'text' => 'text-green-700 dark:text-green-400', 'label' => 'Active'],
    'inactive' => ['dot' => 'bg-zinc-400', 'text' => 'text-zinc-600 dark:text-zinc-400', 'label' => 'Inactive'],
    'pending' => ['dot' => 'bg-yellow-500', 'text' => 'text-yellow-700 dark:text-yellow-400', 'label' => 'Pending'],
    'error' => ['dot' => 'bg-red-500', 'text' => 'text-red-700 dark:text-red-400', 'label' => 'Error'],
];
$statusSet = $statuses[$status] ?? $statuses['active'];
@endphp

<div {{ $attributes->class(['bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700 shadow-sm']) }}>
    <div class="flex items-center justify-between mb-2">
        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $label }}</h3>
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full {{ $statusSet['dot'] }}"></span>
            <span class="text-xs font-medium {{ $statusSet['text'] }}">{{ $statusSet['label'] }}</span>
        </div>
    </div>
    @if($description)
        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
    @endif
</div>
