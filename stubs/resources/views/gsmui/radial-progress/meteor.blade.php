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
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-800 dark:stroke-zinc-200" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="stroke-yellow-400 dark:stroke-yellow-300"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out; filter: drop-shadow(0 0 4px rgba(250, 204, 21, 0.6));" />
        
        {{-- Meteor streaks --}}
        @for($i = 0; $i < 3; $i++)
            @php
                $streakAngle = ($percentage / 100) * 360 - 90 - ($i * 15);
                $streakRad = $streakAngle * M_PI / 180;
                $startX = $size / 2 + ($radius * 0.6) * cos($streakRad);
                $startY = $size / 2 + ($radius * 0.6) * sin($streakRad);
                $endX = $size / 2 + ($radius * 0.9) * cos($streakRad);
                $endY = $size / 2 + ($radius * 0.9) * sin($streakRad);
            @endphp
            <line x1="{{ $startX }}" y1="{{ $startY }}" x2="{{ $endX }}" y2="{{ $endY }}" 
                  stroke="#facc15" stroke-width="1" stroke-linecap="round" 
                  opacity="{{ 0.8 - ($i * 0.2) }}" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-yellow-500 dark:text-yellow-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
