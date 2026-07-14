@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'strokeWidth' => 8,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$radius = ($size - $strokeWidth) / 2;
$circumference = 2 * M_PI * $radius;
$offset = $circumference - ($percentage / 100) * $circumference;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <defs>
            <linearGradient id="plasma-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#ec4899" />
                <stop offset="33%" stop-color="#8b5cf6" />
                <stop offset="66%" stop-color="#06b6d4" />
                <stop offset="100%" stop-color="#22c55e" />
            </linearGradient>
            <filter id="plasma-glow">
                <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                <feMerge>
                    <feMergeNode in="coloredBlur"/>
                    <feMergeNode in="SourceGraphic"/>
                </feMerge>
            </filter>
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth * 1.5 }}" 
                class="stroke-zinc-100 dark:stroke-zinc-800" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#plasma-gradient)"
                filter="url(#plasma-glow)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius * 0.6 }}" 
                fill="none" stroke-width="1" 
                class="stroke-pink-300 dark:stroke-pink-700" opacity="0.5" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold bg-gradient-to-r from-pink-500 via-purple-500 to-cyan-500 bg-clip-text text-transparent">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
