@props([
    'status' => 'loading',
    'size' => 'md',
    'color' => null,
])

@php
$defaultColors = [
    'success' => 'bg-green-500',
    'error' => 'bg-red-500',
    'warning' => 'bg-yellow-500',
    'info' => 'bg-blue-500',
    'loading' => 'bg-zinc-500',
];

$sizes = [
    'sm' => 'h-3 w-3',
    'md' => 'h-4 w-4',
    'lg' => 'h-5 w-5',
];

$colorClass = $color ?? ($defaultColors[$status] ?? 'bg-zinc-500');
$sizeClass = $sizes[$size] ?? 'h-4 w-4';
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <svg class="animate-spin {{ $sizeClass }} {{ $colorClass }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    {{ $slot }}
</div>
