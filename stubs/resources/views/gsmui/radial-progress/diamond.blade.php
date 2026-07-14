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
$diamonds = 8;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-200 dark:stroke-zinc-700" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="stroke-cyan-500 dark:stroke-cyan-400"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Diamond accents --}}
        @for($i = 0; $i < $diamonds; $i++)
            @php
                $angle = ($i / $diamonds) * 360 - 90;
                $rad = $angle * M_PI / 180;
                $dX = $size / 2 + $radius * cos($rad);
                $dY = $size / 2 + $radius * sin($rad);
                $isActive = ($i / $diamonds) * 100 < $percentage;
            @endphp
            <polygon points="{{ $dX }},{{ $dY - 5 }} {{ $dX + 5 }},{{ $dY }} {{ $dX }},{{ $dY + 5 }} {{ $dX - 5 }},{{ $dY }}"
                     class="{{ $isActive ? 'fill-cyan-500 dark:fill-cyan-400' : 'fill-zinc-300 dark:fill-zinc-600' }}"
                     style="transition: all 0.3s ease-out {{ $i * 40 }}ms;" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
