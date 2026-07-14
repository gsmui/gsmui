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
$stars = 16;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="1" 
                class="stroke-zinc-200 dark:stroke-zinc-700" stroke-dasharray="2 4" />
        
        @for($i = 0; $i < $stars; $i++)
            @php
                $angle = ($i / $stars) * 360 - 90;
                $rad = $angle * M_PI / 180;
                $starX = $size / 2 + $radius * cos($rad);
                $starY = $size / 2 + $radius * sin($rad);
                $isFilled = ($i / $stars) * 100 < $percentage;
                $starSize = $isFilled ? 4 : 2;
            @endphp
            <circle cx="{{ $starX }}" cy="{{ $starY }}" r="{{ $starSize }}" 
                    class="{{ $isFilled ? 'fill-amber-400 dark:fill-amber-300' : 'fill-zinc-300 dark:fill-zinc-600' }}"
                    style="transition: all 0.5s ease-out; {{ $isFilled ? 'filter: drop-shadow(0 0 4px rgba(251, 191, 36, 0.6));' : '' }}" />
        @endfor
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="stroke-amber-500 dark:stroke-amber-400"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out; opacity: 0.3;" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
