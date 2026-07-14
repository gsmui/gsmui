@props([
    'status' => 'info',
    'size' => 'md',
    'color' => null,
])

@php
$defaultColors = [
    'success' => 'text-green-500',
    'error' => 'text-red-500',
    'warning' => 'text-yellow-500',
    'info' => 'text-blue-500',
];

$sizes = [
    'sm' => 'h-3 w-3',
    'md' => 'h-4 w-4',
    'lg' => 'h-5 w-5',
];

$colorClass = $color ?? ($defaultColors[$status] ?? 'text-zinc-500');
$sizeClass = $sizes[$size] ?? 'h-4 w-4';
@endphp

<span {{ $attributes->class(['inline-flex items-center', $colorClass]) }}>
    <svg class="{{ $sizeClass }}" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
    </svg>
    {{ $slot }}
</span>
