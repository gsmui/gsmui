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
$teeth = 12;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full animate-spin-slow" viewBox="0 0 {{ $size }} {{ $size }}" style="animation-duration: 20s;">
        {{-- Gear teeth --}}
        @for($i = 0; $i < $teeth; $i++)
            @php
                $angle = ($i / $teeth) * 360;
                $rad = $angle * M_PI / 180;
                $toothX = $size / 2 + ($radius + 4) * cos($rad);
                $toothY = $size / 2 + ($radius + 4) * sin($rad);
                $isActive = ($i / $teeth) * 100 < $percentage;
            @endphp
            <rect x="{{ $toothX - 4 }}" y="{{ $toothY - 4 }}" width="8" height="8" rx="1"
                  class="{{ $isActive ? 'fill-zinc-600 dark:fill-zinc-300' : 'fill-zinc-300 dark:fill-zinc-600' }}"
                  transform="rotate({{ $angle }} {{ $toothX }} {{ $toothY }})" />
        @endfor
    </svg>
    
    <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-200 dark:stroke-zinc-700" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="stroke-zinc-600 dark:stroke-zinc-300"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center z-10">
            <span class="text-lg font-bold text-zinc-700 dark:text-zinc-300">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
