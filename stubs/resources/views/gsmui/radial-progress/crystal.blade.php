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
$facets = 8;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        <defs>
            <linearGradient id="crystal-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#67e8f9" />
                <stop offset="50%" stop-color="#a5f3fc" />
                <stop offset="100%" stop-color="#22d3ee" />
            </linearGradient>
        </defs>
        
        {{-- Crystal facets --}}
        @for($i = 0; $i < $facets; $i++)
            @php
                $angle = ($i / $facets) * 360;
                $nextAngle = (($i + 1) / $facets) * 360;
                $rad = $angle * M_PI / 180;
                $nextRad = $nextAngle * M_PI / 180;
                $isActive = ($i / $facets) * 100 < $percentage;
                
                $x1 = $size / 2 + $radius * cos($rad);
                $y1 = $size / 2 + $radius * sin($rad);
                $x2 = $size / 2 + $radius * cos($nextRad);
                $y2 = $size / 2 + $radius * sin($nextRad);
                $cx = $size / 2 + ($radius * 0.6) * cos(($rad + $nextRad) / 2);
                $cy = $size / 2 + ($radius * 0.6) * sin(($rad + $nextRad) / 2);
            @endphp
            <polygon points="{{ $size / 2 }},{{ $size / 2 }} {{ $x1 }},{{ $y1 }} {{ $x2 }},{{ $y2 }}"
                     class="{{ $isActive ? 'fill-cyan-300 dark:fill-cyan-700' : 'fill-zinc-200 dark:fill-zinc-800' }}"
                     opacity="{{ $isActive ? 0.4 : 0.15 }}"
                     style="transition: all 0.3s ease-out {{ $i * 40 }}ms;" />
        @endfor
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-cyan-200 dark:stroke-cyan-800" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#crystal-grad)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Center crystal --}}
        <polygon points="{{ $size / 2 }},{{ $size * 0.4 }} {{ $size * 0.55 }},{{ $size / 2 }} {{ $size / 2 }},{{ $size * 0.6 }} {{ $size * 0.45 }},{{ $size / 2 }}"
                 class="fill-cyan-400 dark:fill-cyan-500" opacity="0.8" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center mt-2">
            <span class="text-sm font-bold text-cyan-600 dark:text-cyan-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
