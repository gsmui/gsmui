@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'strokeWidth' => 10,
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
            <linearGradient id="tundra-grad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#bae6fd" />
                <stop offset="50%" stop-color="#7dd3fc" />
                <stop offset="100%" stop-color="#38bdf8" />
            </linearGradient>
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-sky-100 dark:stroke-sky-900/30" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#tundra-grad)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Ice crystals --}}
        @for($i = 0; $i < 6; $i++)
            @php
                $angle = ($i / 6) * 360;
                $rad = $angle * M_PI / 180;
                $cx = $size / 2 + ($radius + 8) * cos($rad);
                $cy = $size / 2 + ($radius + 8) * sin($rad);
            @endphp
            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="2" class="fill-sky-300 dark:fill-sky-600" opacity="0.5" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-sky-600 dark:text-sky-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
