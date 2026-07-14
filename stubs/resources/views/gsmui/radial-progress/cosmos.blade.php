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
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        <defs>
            <radialGradient id="cosmos-bg" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="#1e1b4b" />
                <stop offset="100%" stop-color="#0c0a09" />
            </radialGradient>
            <linearGradient id="cosmos-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#818cf8" />
                <stop offset="50%" stop-color="#c084fc" />
                <stop offset="100%" stop-color="#f472b6" />
            </linearGradient>
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" fill="url(#cosmos-bg)" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-violet-900/50" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#cosmos-grad)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out; filter: drop-shadow(0 0 8px rgba(192, 132, 252, 0.5));" />
        
        {{-- Stars --}}
        @for($i = 0; $i < 12; $i++)
            @php
                $sx = $size * (0.15 + ($i * 0.07));
                $sy = $size * (0.2 + (($i * 37) % 60) / 100);
                $sr = 0.5 + ($i % 3) * 0.5;
            @endphp
            <circle cx="{{ $sx }}" cy="{{ $sy }}" r="{{ $sr }}" class="fill-white" opacity="{{ 0.3 + ($i % 4) * 0.15 }}" />
        @endfor
        
        {{-- Planet --}}
        <circle cx="{{ $size * 0.7 }}" cy="{{ $size * 0.35 }}" r="3" class="fill-violet-400" opacity="0.6" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-violet-400 dark:text-violet-300" style="text-shadow: 0 0 6px rgba(192, 132, 252, 0.5);">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
