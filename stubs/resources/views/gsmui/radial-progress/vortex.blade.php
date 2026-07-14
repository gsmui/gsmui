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
$arms = 3;
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full animate-spin-slow" viewBox="0 0 {{ $size }} {{ $size }}" style="animation-duration: 8s;">
        @for($arm = 0; $arm < $arms; $arm++)
            @php
                $armOffset = ($arm / $arms) * $circumference;
                $segmentLength = $circumference * 0.3;
            @endphp
            <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                    fill="none" stroke-width="{{ $strokeWidth * 0.6 }}" 
                    stroke-linecap="round"
                    class="stroke-purple-500 dark:stroke-purple-400"
                    opacity="0.6"
                    style="stroke-dasharray: {{ $segmentLength }} {{ $circumference - $segmentLength }}; stroke-dashoffset: -{{ $armOffset }}; transform: rotate(-90deg); transform-origin: center;" />
        @endfor
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-purple-100 dark:stroke-purple-900/30" />
        
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius * 0.3 }}" 
                class="fill-purple-500 dark:fill-purple-400 opacity-20" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
