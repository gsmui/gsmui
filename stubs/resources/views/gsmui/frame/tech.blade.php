@props([
    'color' => 'blue',
    'corners' => 'cut',
    'scanline' => false,
])

@php
$colors = [
    'blue' => ['border' => 'border-cyan-500', 'bg' => 'bg-cyan-500/10', 'text' => 'text-cyan-500'],
    'green' => ['border' => 'border-green-500', 'bg' => 'bg-green-500/10', 'text' => 'text-green-500'],
    'purple' => ['border' => 'border-purple-500', 'bg' => 'bg-purple-500/10', 'text' => 'text-purple-500'],
];

$colorData = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->class([
    'relative',
    $colorData['bg'],
    $scanline ? 'overflow-hidden' : '',
]) }} style="clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 16px 100%, 0 calc(100% - 16px));">
    {{-- Border --}}
    <div class="absolute inset-0 border {{ $colorData['border'] }}" style="clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 16px 100%, 0 calc(100% - 16px));"></div>
    
    {{-- Corner decorations --}}
    <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 {{ $colorData['border'] }}"></div>
    <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 {{ $colorData['border'] }}"></div>
    <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 {{ $colorData['border'] }}"></div>
    <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 {{ $colorData['border'] }}"></div>
    
    @if($scanline)
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-cyan-500/5 to-transparent pointer-events-none"></div>
    @endif
    
    <div class="relative z-10 p-4">
        {{ $slot }}
    </div>
</div>
