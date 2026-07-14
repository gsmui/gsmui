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
$segments = 12;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        @for($i = 0; $i < $segments; $i++)
            @php
                $segmentLength = $circumference / $segments;
                $gap = 4;
                $actualLength = $segmentLength - $gap;
                $rotation = ($i / $segments) * 360;
                $isFilled = ($i / $segments) * 100 < $percentage;
            @endphp
            <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                    fill="none" stroke-width="{{ $strokeWidth }}" 
                    stroke-linecap="round"
                    class="{{ $isFilled ? 'stroke-indigo-500 dark:stroke-indigo-400' : 'stroke-zinc-200 dark:stroke-zinc-700' }}"
                    style="stroke-dasharray: {{ $actualLength }} {{ $gap }}; stroke-dashoffset: -{{ $i * $segmentLength }}; transition: all 0.5s ease-out;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
