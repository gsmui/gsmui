@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'strokeWidth' => 8,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$outerRadius = ($size - $strokeWidth) / 2;
$innerRadius = $outerRadius - $strokeWidth - 4;
$outerCircumference = 2 * M_PI * $outerRadius;
$innerCircumference = 2 * M_PI * $innerRadius;
$outerOffset = $outerCircumference - ($percentage / 100) * $outerCircumference;
$innerOffset = $innerCircumference - (($percentage * 0.7) / 100) * $innerCircumference;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <defs>
            <linearGradient id="outer-ring-grad" gradientUnits="userSpaceOnUse"
                            x1="0" y1="0" x2="{{ $size }}" y2="{{ $size }}">
                <stop offset="0%" stop-color="#3b82f6" />
                <stop offset="100%" stop-color="#8b5cf6" />
            </linearGradient>
            <linearGradient id="inner-ring-grad" gradientUnits="userSpaceOnUse"
                            x1="{{ $size }}" y1="0" x2="0" y2="{{ $size }}">
                <stop offset="0%" stop-color="#06b6d4" />
                <stop offset="100%" stop-color="#22c55e" />
            </linearGradient>
        </defs>
        
        {{-- Outer track --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $outerRadius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-200 dark:stroke-zinc-700" />
        
        {{-- Outer progress --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $outerRadius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#outer-ring-grad)"
                style="stroke-dasharray: {{ $outerCircumference }}; stroke-dashoffset: {{ $outerOffset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Inner track --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $innerRadius }}" 
                fill="none" stroke-width="{{ $strokeWidth * 0.6 }}" 
                class="stroke-zinc-200 dark:stroke-zinc-700" />
        
        {{-- Inner progress --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $innerRadius }}" 
                fill="none" stroke-width="{{ $strokeWidth * 0.6 }}" 
                stroke-linecap="round"
                stroke="url(#inner-ring-grad)"
                style="stroke-dasharray: {{ $innerCircumference }}; stroke-dashoffset: {{ $innerOffset }}; transition: stroke-dashoffset 0.5s ease-out;" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
