@props([
    'color' => 'gold',
    'seal' => true,
])

@php
$colors = [
    'gold' => ['border' => 'border-amber-600', 'accent' => 'text-amber-600', 'seal' => 'bg-amber-500'],
    'silver' => ['border' => 'border-zinc-400', 'accent' => 'text-zinc-400', 'seal' => 'bg-zinc-500'],
];

$colorData = $colors[$color] ?? $colors['gold'];
@endphp

<div {{ $attributes->class([
    'bg-amber-50 dark:bg-amber-950/30 p-8 border-4',
    $colorData['border'],
    'shadow-xl relative',
]) }}>
    {{-- Corner decorations --}}
    <div class="absolute top-4 left-4 text-2xl {{ $colorData['accent'] }}">❖</div>
    <div class="absolute top-4 right-4 text-2xl {{ $colorData['accent'] }}">❖</div>
    <div class="absolute bottom-4 left-4 text-2xl {{ $colorData['accent'] }}">❖</div>
    <div class="absolute bottom-4 right-4 text-2xl {{ $colorData['accent'] }}">❖</div>
    
    {{ $slot }}
    
    @if($seal)
    <div class="absolute bottom-8 right-8 w-16 h-16 {{ $colorData['seal'] }} rounded-full flex items-center justify-center shadow-lg">
        <div class="w-12 h-12 border-2 border-white/50 rounded-full flex items-center justify-center">
            <span class="text-white font-bold text-xs">SEAL</span>
        </div>
    </div>
    @endif
</div>
