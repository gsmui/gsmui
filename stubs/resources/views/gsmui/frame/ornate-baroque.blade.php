@props([
    'color' => 'gold',
    'thickness' => 'thick',
])

@php
$colors = [
    'gold' => ['border' => 'border-amber-600', 'bg' => 'bg-amber-100 dark:bg-amber-900/30', 'accent' => 'text-amber-600'],
    'silver' => ['border' => 'border-zinc-400', 'bg' => 'bg-zinc-100 dark:bg-zinc-800 dark:bg-zinc-800', 'accent' => 'text-zinc-400'],
];

$colorData = $colors[$color] ?? $colors['gold'];
@endphp

<div class="relative p-6">
    {{-- Outer frame --}}
    <div class="absolute inset-0 border-8 {{ $colorData['border'] }} rounded-lg opacity-50"></div>
    {{-- Inner frame --}}
    <div class="absolute inset-2 border-4 {{ $colorData['border'] }} rounded-md opacity-70"></div>
    {{-- Decorative corners --}}
    <div class="absolute top-1 left-1 text-2xl {{ $colorData['accent'] }}">❧</div>
    <div class="absolute top-1 right-1 text-2xl {{ $colorData['accent'] }}" style="transform: scaleX(-1);">❧</div>
    <div class="absolute bottom-1 left-1 text-2xl {{ $colorData['accent'] }}" style="transform: scaleY(-1);">❧</div>
    <div class="absolute bottom-1 right-1 text-2xl {{ $colorData['accent'] }}" style="transform: scale(-1);">❧</div>
    
    <div class="relative z-10 {{ $colorData['bg'] }} rounded p-4">
        {{ $slot }}
    </div>
</div>
