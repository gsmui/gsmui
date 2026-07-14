@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$bars = 12;
$innerRadius = $size * 0.2;
$outerRadius = $size * 0.45;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        @for($i = 0; $i < $bars; $i++)
            @php
                $angle = ($i / $bars) * 360 - 90;
                $rad = $angle * M_PI / 180;
                $barHeight = (($outerRadius - $innerRadius) * ($percentage / 100));
                $startX = $size / 2 + $innerRadius * cos($rad);
                $startY = $size / 2 + $innerRadius * sin($rad);
                $endX = $size / 2 + ($innerRadius + $barHeight) * cos($rad);
                $endY = $size / 2 + ($innerRadius + $barHeight) * sin($rad);
                $isActive = ($i / $bars) * 100 < $percentage;
            @endphp
            <line x1="{{ $startX }}" y1="{{ $startY }}" x2="{{ $endX }}" y2="{{ $endY }}" 
                  stroke-width="6" stroke-linecap="round"
                  class="{{ $isActive ? 'stroke-cyan-500 dark:stroke-cyan-400' : 'stroke-zinc-200 dark:stroke-zinc-700' }}"
                  style="transition: all 0.3s ease-out {{ $i * 30 }}ms;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
