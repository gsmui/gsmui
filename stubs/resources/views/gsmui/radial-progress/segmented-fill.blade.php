@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$segments = 10;
$segmentAngle = 360 / $segments;
$center = $size / 2;
$outerR = $size * 0.45;
$innerR = $size * 0.25;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        @for($i = 0; $i < $segments; $i++)
            @php
                $startAngle = ($i * $segmentAngle - 90) * M_PI / 180;
                $endAngle = (($i + 1) * $segmentAngle - 90) * M_PI / 180;
                $isActive = ($i / $segments) * 100 < $percentage;
                
                $x1Outer = $center + $outerR * cos($startAngle);
                $y1Outer = $center + $outerR * sin($startAngle);
                $x2Outer = $center + $outerR * cos($endAngle);
                $y2Outer = $center + $outerR * sin($endAngle);
                $x1Inner = $center + $innerR * cos($endAngle);
                $y1Inner = $center + $innerR * sin($endAngle);
                $x2Inner = $center + $innerR * cos($startAngle);
                $y2Inner = $center + $innerR * sin($startAngle);
                
                $path = "M {$x1Outer} {$y1Outer} A {$outerR} {$outerR} 0 0 1 {$x2Outer} {$y2Outer} L {$x1Inner} {$y1Inner} A {$innerR} {$innerR} 0 0 0 {$x2Inner} {$y2Inner} Z";
            @endphp
            <path d="{{ $path }}" 
                  class="{{ $isActive ? 'fill-emerald-500 dark:fill-emerald-400' : 'fill-zinc-200 dark:fill-zinc-700' }}"
                  style="transition: all 0.3s ease-out {{ $i * 40 }}ms;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
