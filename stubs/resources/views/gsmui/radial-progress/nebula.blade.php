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
            <radialGradient id="nebula-bg" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#1e1b4b" />
                <stop offset="100%" stop-color="#0f172a" />
            </radialGradient>
            <linearGradient id="nebula-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#c084fc" />
                <stop offset="50%" stop-color="#818cf8" />
                <stop offset="100%" stop-color="#38bdf8" />
            </linearGradient>
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="url(#nebula-bg)" stroke-width="0" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-indigo-900/50" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#nebula-gradient)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out; filter: drop-shadow(0 0 8px rgba(139, 92, 246, 0.5));" />
        
        {{-- Stars --}}
        @for($i = 0; $i < 8; $i++)
            @php
                $starAngle = ($i / 8) * 360;
                $starRad = $starAngle * M_PI / 180;
                $starR = $radius * (0.3 + ($i % 3) * 0.2);
                $starX = $size / 2 + $starR * cos($starRad);
                $starY = $size / 2 + $starR * sin($starRad);
            @endphp
            <circle cx="{{ $starX }}" cy="{{ $starY }}" r="1" class="fill-white opacity-{{ 30 + ($i * 10) }}" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-indigo-400 dark:text-indigo-300">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
