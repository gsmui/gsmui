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
    <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size }}">
        {{-- Outer orbital ring --}}
        <ellipse cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" rx="{{ $radius }}" ry="{{ $radius * 0.4 }}" 
                 fill="none" stroke-width="1" class="stroke-zinc-300 dark:stroke-zinc-600"
                 transform="rotate(-30 {{ $size / 2 }} {{ $size / 2 }})" />
        
        {{-- Inner orbital ring --}}
        <ellipse cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" rx="{{ $radius * 0.7 }}" ry="{{ $radius * 0.3 }}" 
                 fill="none" stroke-width="1" class="stroke-zinc-300 dark:stroke-zinc-600"
                 transform="rotate(30 {{ $size / 2 }} {{ $size / 2 }})" />
        
        {{-- Progress ring --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="stroke-zinc-100 dark:stroke-zinc-800" transform="rotate(-90 {{ $size / 2 }} {{ $size / 2 }})" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="stroke-cyan-500 dark:stroke-cyan-400"
                transform="rotate(-90 {{ $size / 2 }} {{ $size / 2 }})"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out;" />
        
        {{-- Nucleus --}}
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="4" class="fill-cyan-500 dark:fill-cyan-400" />
        
        {{-- Electrons --}}
        <circle cx="{{ $size / 2 + $radius * 0.5 }}" cy="{{ $size / 2 }}" r="2" class="fill-cyan-400 animate-spin" style="transform-origin: {{ $size / 2 }}px {{ $size / 2 }}px; animation-duration: 3s;" />
        <circle cx="{{ $size / 2 - $radius * 0.3 }}" cy="{{ $size / 2 - $radius * 0.2 }}" r="2" class="fill-cyan-400 animate-spin" style="transform-origin: {{ $size / 2 }}px {{ $size / 2 }}px; animation-duration: 2s; animation-direction: reverse;" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex items-center justify-center" style="pointer-events: none;">
            <span class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
