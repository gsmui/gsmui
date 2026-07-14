@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$radius = $size * 0.4;
$dots = 24;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        @for($i = 0; $i < $dots; $i++)
            @php
                $angle = ($i / $dots) * 360 - 90;
                $rad = $angle * M_PI / 180;
                $dotX = $size / 2 + $radius * cos($rad);
                $dotY = $size / 2 + $radius * sin($rad);
                $isActive = ($i / $dots) * 100 < $percentage;
                $dotSize = $isActive ? 5 : 3;
            @endphp
            <circle cx="{{ $dotX }}" cy="{{ $dotY }}" r="{{ $dotSize }}" 
                    class="{{ $isActive ? 'fill-indigo-500 dark:fill-indigo-400' : 'fill-zinc-200 dark:fill-zinc-700' }}"
                    style="transition: all 0.3s ease-out {{ $i * 20 }}ms;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
