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
$stars = 5;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <defs>
            <linearGradient id="star-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#eab308" />
                <stop offset="100%" stop-color="#f59e0b" />
            </linearGradient>
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-amber-100 dark:stroke-amber-900/30" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#star-gradient)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Star indicators --}}
        @for($i = 0; $i < $stars; $i++)
            @php
                $angle = ($i / $stars) * 360 - 90;
                $rad = $angle * M_PI / 180;
                $sX = $size / 2 + $radius * cos($rad);
                $sY = $size / 2 + $radius * sin($rad);
                $isActive = ($i / $stars) * 100 < $percentage;
                $starSize = $isActive ? 8 : 5;
            @endphp
            <polygon points="{{ $sX }},{{ $sY - $starSize }} {{ $sX + $starSize * 0.3 }},{{ $sY - $starSize * 0.3 }} {{ $sX + $starSize }},{{ $sY }} {{ $sX + $starSize * 0.3 }},{{ $sY + $starSize * 0.3 }} {{ $sX }},{{ $sY + $starSize }} {{ $sX - $starSize * 0.3 }},{{ $sY + $starSize * 0.3 }} {{ $sX - $starSize }},{{ $sY }} {{ $sX - $starSize * 0.3 }},{{ $sY - $starSize * 0.3 }}"
                     class="{{ $isActive ? 'fill-amber-400 dark:fill-amber-300' : 'fill-zinc-300 dark:fill-zinc-600' }}"
                     style="transition: all 0.3s ease-out {{ $i * 60 }}ms;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
