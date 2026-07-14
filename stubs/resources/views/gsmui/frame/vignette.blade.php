@props([
    'intensity' => 'md',
    'color' => 'black',
])

@php
$intensities = [
    'sm' => 'from-transparent via-transparent to-black/30',
    'md' => 'from-transparent via-transparent to-black/50',
    'lg' => 'from-transparent via-transparent to-black/70',
];

$colors = [
    'black' => 'to-black/50',
    'white' => 'to-white/50',
];

$intensityClass = $intensities[$intensity] ?? 'from-transparent via-transparent to-black/50';
@endphp

<div class="relative overflow-hidden rounded-xl">
    {{ $slot }}
    <div class="absolute inset-0 pointer-events-none bg-radial-gradient {{ $intensityClass }}"></div>
</div>
