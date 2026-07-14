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
$spectrumColors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#3b82f6', '#8b5cf6', '#ec4899'];
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <defs>
            <linearGradient id="spectrum-gradient" gradientUnits="userSpaceOnUse" 
                            x1="{{ $size * 0.1 }}" y1="{{ $size / 2 }}" 
                            x2="{{ $size * 0.9 }}" y2="{{ $size / 2 }}">
                @foreach($spectrumColors as $index => $color)
                    <stop offset="{{ ($index / (count($spectrumColors) - 1)) * 100 }}%" stop-color="{{ $color }}" />
                @endforeach
            </linearGradient>
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-200 dark:stroke-zinc-700" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#spectrum-gradient)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Prismatic center refraction --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius * 0.3 }}" 
                fill="none" stroke-width="2" 
                stroke="url(#spectrum-gradient)" opacity="0.3" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold bg-gradient-to-r from-red-500 via-green-500 to-blue-500 bg-clip-text text-transparent">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
