@props([
    'color' => 'cyan',
    'glitch' => false,
])

@php
$colors = [
    'cyan' => ['border' => 'border-cyan-500', 'shadow' => 'shadow-cyan-500/50', 'glow' => '0 0 20px rgba(6, 182, 212, 0.5)'],
    'magenta' => ['border' => 'border-pink-500', 'shadow' => 'shadow-pink-500/50', 'glow' => '0 0 20px rgba(236, 72, 153, 0.5)'],
    'yellow' => ['border' => 'border-yellow-500', 'shadow' => 'shadow-yellow-500/50', 'glow' => '0 0 20px rgba(234, 179, 8, 0.5)'],
];

$colorData = $colors[$color] ?? $colors['cyan'];
@endphp

<div {{ $attributes->class([
    'relative rounded-lg border-2',
    $colorData['border'],
    'bg-zinc-900',
    $glitch ? 'animate-glitch' : '',
]) }} style="box-shadow: {{ $colorData['glow'] }}; clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));">
    {{-- Corner decorations --}}
    <div class="absolute top-0 left-0 w-3 h-3 {{ $colorData['border'] }} border-t-2 border-l-2"></div>
    <div class="absolute top-0 right-0 w-3 h-3 {{ $colorData['border'] }} border-t-2 border-r-2"></div>
    <div class="absolute bottom-0 left-0 w-3 h-3 {{ $colorData['border'] }} border-b-2 border-l-2"></div>
    <div class="absolute bottom-0 right-0 w-3 h-3 {{ $colorData['border'] }} border-b-2 border-r-2"></div>
    
    {{ $slot }}
</div>
