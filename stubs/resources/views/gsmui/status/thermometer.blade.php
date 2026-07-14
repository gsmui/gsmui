@props([
    'temperature' => 72,
    'unit' => '°',
    'status' => 'info',
    'size' => 'md',
])

@php
$fillColor = match(true) {
    $temperature >= 100 => 'bg-red-500',
    $temperature >= 80 => 'bg-orange-500',
    $temperature >= 60 => 'bg-green-500',
    default => 'bg-blue-500',
};

$sizes = [
    'sm' => 'h-6 w-16 text-xs',
    'md' => 'h-8 w-20 text-sm',
    'lg' => 'h-10 w-24 text-base',
];

$sizeClass = $sizes[$size] ?? 'h-8 w-20 text-sm';
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2 font-medium tabular-nums', $sizeClass]) }}>
    <svg class="h-4 w-4 {{ $fillColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>{{ $temperature }}{{ $unit }}</span>
</div>
