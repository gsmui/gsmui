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
            <radialGradient id="eclipse-gradient" cx="40%" cy="40%">
                <stop offset="0%" stop-color="#fbbf24" />
                <stop offset="100%" stop-color="#f59e0b" />
            </radialGradient>
        </defs>
        
        {{-- Sun corona --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius + 4 }}" 
                fill="none" stroke-width="2" 
                class="stroke-amber-300 dark:stroke-amber-600" opacity="0.5" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-amber-200 dark:stroke-amber-800" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#eclipse-gradient)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out; filter: drop-shadow(0 0 6px rgba(251, 191, 36, 0.6));" />
        
        {{-- Moon shadow --}}
        <circle cx="{{ $size / 2 + $radius * 0.2 }}" cy="{{ $size / 2 - $radius * 0.1 }}" 
                r="{{ $radius * 0.4 }}" 
                class="fill-zinc-900 dark:fill-zinc-100" opacity="0.15" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
