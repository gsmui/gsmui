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
        <defs>
            <linearGradient id="prism-gradient" gradientUnits="userSpaceOnUse"
                            x1="0" y1="0" x2="{{ $size }}" y2="{{ $size }}">
                <stop offset="0%" stop-color="#ff0000" />
                <stop offset="16%" stop-color="#ff8800" />
                <stop offset="33%" stop-color="#ffff00" />
                <stop offset="50%" stop-color="#00ff00" />
                <stop offset="66%" stop-color="#0088ff" />
                <stop offset="83%" stop-color="#8800ff" />
                <stop offset="100%" stop-color="#ff00ff" />
            </linearGradient>
        </defs>
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-100 dark:stroke-zinc-800" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                stroke="url(#prism-gradient)"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out; filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.3));" />
        
        {{-- Light rays --}}
        @for($i = 0; $i < 6; $i++)
            @php
                $rayAngle = $i * 60;
                $rayRad = $rayAngle * M_PI / 180;
                $rayLength = $radius * 0.15;
                $startX = $size / 2 + ($radius - $rayLength) * cos($rayRad);
                $startY = $size / 2 + ($radius - $rayLength) * sin($rayRad);
                $endX = $size / 2 + ($radius + $rayLength) * cos($rayRad);
                $endY = $size / 2 + ($radius + $rayLength) * sin($rayRad);
            @endphp
            <line x1="{{ $startX }}" y1="{{ $startY }}" x2="{{ $endX }}" y2="{{ $endY }}" 
                  stroke="white" stroke-width="1" opacity="0.3" />
        @endfor
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-zinc-700 dark:text-zinc-300">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
