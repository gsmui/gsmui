@props([
    'color' => 'white',
    'intensity' => 'md',
])

@php
$intensities = [
    'sm' => 'opacity-20',
    'md' => 'opacity-30',
    'lg' => 'opacity-40',
];

$colors = [
    'white' => 'bg-white dark:bg-zinc-800',
    'blue' => 'bg-blue-500',
    'purple' => 'bg-purple-500',
    'pink' => 'bg-pink-500',
];

$colorClass = $colors[$color] ?? 'bg-white dark:bg-zinc-800';
$intensityClass = $intensities[$intensity] ?? 'opacity-30';
@endphp

<div class="relative overflow-hidden rounded-xl">
    {{ $slot }}
    <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-black/50 via-transparent to-black/50"></div>
    <div class="absolute inset-0 pointer-events-none {{ $colorClass }} {{ $intensityClass }} mix-blend-overlay"></div>
</div>
