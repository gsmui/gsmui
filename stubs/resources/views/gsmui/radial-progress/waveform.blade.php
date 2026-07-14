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
$bars = 24;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-200 dark:stroke-zinc-700" />
        
        {{-- Waveform bars --}}
        @for($i = 0; $i < $bars; $i++)
            @php
                $angle = ($i / $bars) * 360 - 90;
                $rad = $angle * M_PI / 180;
                $barHeight = (4 + sin($i * 0.8) * 8) * ($i / $bars * 100 < $percentage ? 1 : 0.3);
                $x = $size / 2 + ($radius - $barHeight / 2) * cos($rad);
                $y = $size / 2 + ($radius - $barHeight / 2) * sin($rad);
                $endX = $size / 2 + ($radius + $barHeight / 2) * cos($rad);
                $endY = $size / 2 + ($radius + $barHeight / 2) * sin($rad);
                $isActive = ($i / $bars) * 100 < $percentage;
            @endphp
            <line x1="{{ $x }}" y1="{{ $y }}" x2="{{ $endX }}" y2="{{ $endY }}" 
                  stroke-width="3" stroke-linecap="round"
                  class="{{ $isActive ? 'stroke-emerald-500 dark:stroke-emerald-400' : 'stroke-zinc-300 dark:stroke-zinc-600' }}"
                  style="transition: all 0.3s ease-out {{ $i * 20 }}ms;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
