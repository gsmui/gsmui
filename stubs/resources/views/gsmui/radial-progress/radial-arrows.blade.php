@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$radius = $size * 0.35;
$arrows = 8;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        @for($i = 0; $i < $arrows; $i++)
            @php
                $angle = ($i / $arrows) * 360 - 90;
                $rad = $angle * M_PI / 180;
                $isActive = ($i / $arrows) * 100 < $percentage;
                $centerX = $size / 2 + $radius * cos($rad);
                $centerY = $size / 2 + $radius * sin($rad);
                $arrowSize = 8;
            @endphp
            <polygon 
                points="{{ $centerX }},{{ $centerY - $arrowSize }} {{ $centerX + $arrowSize }},{{ $centerY + $arrowSize / 2 }} {{ $centerX - $arrowSize }},{{ $centerY + $arrowSize / 2 }}"
                class="{{ $isActive ? 'fill-rose-500 dark:fill-rose-400' : 'fill-zinc-200 dark:fill-zinc-700' }}"
                transform="rotate({{ $angle + 90 }} {{ $centerX }} {{ $centerY }})"
                style="transition: all 0.3s ease-out {{ $i * 50 }}ms;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-rose-600 dark:text-rose-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
