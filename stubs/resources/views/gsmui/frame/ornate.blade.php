@props([
    'style' => 'classic',
    'color' => 'gold',
])

@php
$colors = [
    'gold' => ['border' => 'border-amber-500', 'text' => 'text-amber-500'],
    'silver' => ['border' => 'border-zinc-400', 'text' => 'text-zinc-400'],
    'bronze' => ['border' => 'border-orange-600', 'text' => 'text-orange-600'],
];

$colorData = $colors[$color] ?? $colors['gold'];
@endphp

<div class="relative p-4">
    {{-- Outer decorative border --}}
    <div class="absolute inset-0 border-4 {{ $colorData['border'] }} rounded-xl opacity-30"></div>
    {{-- Inner decorative border --}}
    <div class="absolute inset-2 border-2 {{ $colorData['border'] }} rounded-lg opacity-50"></div>
    {{-- Corner ornaments --}}
    <div class="absolute top-0 left-0 w-6 h-6 {{ $colorData['text'] }}">✦</div>
    <div class="absolute top-0 right-0 w-6 h-6 {{ $colorData['text'] }}">✦</div>
    <div class="absolute bottom-0 left-0 w-6 h-6 {{ $colorData['text'] }}">✦</div>
    <div class="absolute bottom-0 right-0 w-6 h-6 {{ $colorData['text'] }}">✦</div>
    
    <div class="relative z-10 bg-white dark:bg-zinc-800 dark:bg-zinc-900 rounded-lg p-4">
        {{ $slot }}
    </div>
</div>
