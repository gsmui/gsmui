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
            <linearGradient id="heart-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#ec4899" />
                <stop offset="100%" stop-color="#f43f5e" />
            </linearGradient>
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-pink-100 dark:stroke-pink-900/30" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#heart-gradient)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Heart icon --}}
        <path d="M{{ $size / 2 }} {{ $size * 0.55 }} C{{ $size * 0.35 }} {{ $size * 0.4 }}, {{ $size * 0.25 }} {{ $size * 0.55 }}, {{ $size / 2 }} {{ $size * 0.7 }} C{{ $size * 0.75 }} {{ $size * 0.55 }}, {{ $size * 0.65 }} {{ $size * 0.4 }}, {{ $size / 2 }} {{ $size * 0.55 }} Z" 
              class="fill-pink-500 dark:fill-pink-400" opacity="0.9" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center mt-2">
            <span class="text-sm font-bold text-pink-600 dark:text-pink-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
