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
$angle = ($percentage / 100) * 360 - 90;
$rad = $angle * M_PI / 180;
$satelliteX = $size / 2 + $radius * cos($rad);
$satelliteY = $size / 2 + $radius * sin($rad);
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-slate-200 dark:stroke-slate-700" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="stroke-indigo-500 dark:stroke-indigo-400"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Satellite dot --}}
        <circle cx="{{ $satelliteX }}" cy="{{ $satelliteY }}" r="6" 
                class="fill-indigo-500 dark:fill-indigo-400 shadow-lg"
                style="filter: drop-shadow(0 0 6px rgba(99, 102, 241, 0.5)); transition: all 0.5s ease-out;" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
