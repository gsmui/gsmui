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
            <filter id="cyber-glow">
                <feGaussianBlur stdDeviation="2" result="blur"/>
                <feMerge>
                    <feMergeNode in="blur"/>
                    <feMergeNode in="SourceGraphic"/>
                </feMerge>
            </filter>
        </defs>
        
        {{-- Outer scan lines --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius + 3 }}" 
                fill="none" stroke-width="1" class="stroke-fuchsia-500" opacity="0.3"
                stroke-dasharray="4 8" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-fuchsia-900/50" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="stroke-fuchsia-500"
                filter="url(#cyber-glow)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Corner brackets --}}
        <path d="M {{ $size * 0.1 }} {{ $size * 0.3 }} L {{ $size * 0.1 }} {{ $size * 0.1 }} L {{ $size * 0.3 }} {{ $size * 0.1 }}" 
              fill="none" stroke="#d946ef" stroke-width="1" opacity="0.5" />
        <path d="M {{ $size * 0.7 }} {{ $size * 0.1 }} L {{ $size * 0.9 }} {{ $size * 0.1 }} L {{ $size * 0.9 }} {{ $size * 0.3 }}" 
              fill="none" stroke="#d946ef" stroke-width="1" opacity="0.5" />
        <path d="M {{ $size * 0.9 }} {{ $size * 0.7 }} L {{ $size * 0.9 }} {{ $size * 0.9 }} L {{ $size * 0.7 }} {{ $size * 0.9 }}" 
              fill="none" stroke="#d946ef" stroke-width="1" opacity="0.5" />
        <path d="M {{ $size * 0.3 }} {{ $size * 0.9 }} L {{ $size * 0.1 }} {{ $size * 0.9 }} L {{ $size * 0.1 }} {{ $size * 0.7 }}" 
              fill="none" stroke="#d946ef" stroke-width="1" opacity="0.5" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-fuchsia-400" style="text-shadow: 0 0 8px rgba(217, 70, 239, 0.6);">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
