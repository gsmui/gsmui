@props([
    'label' => 'Live',
    'status' => 'active',
    'size' => 'md',
])

@php
$statuses = [
    'active' => ['dot' => 'bg-green-500', 'pulse' => 'bg-green-400', 'text' => 'text-green-700 dark:text-green-400'],
    'recording' => ['dot' => 'bg-red-500', 'pulse' => 'bg-red-400', 'text' => 'text-red-700 dark:text-red-400'],
    'processing' => ['dot' => 'bg-blue-500', 'pulse' => 'bg-blue-400', 'text' => 'text-blue-700 dark:text-blue-400'],
    'warning' => ['dot' => 'bg-yellow-500', 'pulse' => 'bg-yellow-400', 'text' => 'text-yellow-700 dark:text-yellow-400'],
];
$statusSet = $statuses[$status] ?? $statuses['active'];

$sizes = [
    'sm' => 'text-xs gap-1.5',
    'md' => 'text-sm gap-2',
    'lg' => 'text-base gap-2.5',
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class([
    'inline-flex items-center',
    $sizeClass,
]) }}>
    <span class="relative flex h-2.5 w-2.5">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $statusSet['pulse'] }} opacity-75"></span>
        <span class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $statusSet['dot'] }}"></span>
    </span>
    <span class="font-medium {{ $statusSet['text'] }}">{{ $label }}</span>
</div>
