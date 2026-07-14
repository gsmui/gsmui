@props([
    'value' => 75,
    'max' => 100,
    'size' => 120,
    'strokeWidth' => 12,
    'showValue' => true,
])

@php
$percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
$radius = ($size - $strokeWidth) / 2;
$circumference = 2 * M_PI * $radius;
$offset = $circumference - ($percentage / 100) * $circumference;

if ($percentage >= 75) {
    $color = 'stroke-green-500 dark:stroke-green-400';
    $textColor = 'text-green-600 dark:text-green-400';
    $bgColor = 'stroke-green-100 dark:stroke-green-900/30';
} elseif ($percentage >= 25) {
    $color = 'stroke-amber-500 dark:stroke-amber-400';
    $textColor = 'text-amber-600 dark:text-amber-400';
    $bgColor = 'stroke-amber-100 dark:stroke-amber-900/30';
} else {
    $color = 'stroke-red-500 dark:stroke-red-400';
    $textColor = 'text-red-600 dark:text-red-400';
    $bgColor = 'stroke-red-100 dark:stroke-red-900/30';
}
@endphp

<div {{ $attributes->class(['relative inline-flex items-center justify-center']) }} style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                class="{{ $bgColor }}" />
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $radius }}" 
                fill="none" stroke-width="{{ $strokeWidth }}" 
                stroke-linecap="round"
                class="{{ $color }}"
                style="stroke-dasharray: {{ $circumference }}; stroke-dashoffset: {{ $offset }}; transition: stroke-dashoffset 0.5s ease-out, stroke 0.3s ease-out;" />
    </svg>
    
    @if($showValue)
        <div class="absolute inset-0 flex flex-col items-center justify-center">
            <svg class="w-5 h-5 {{ $textColor }} mb-0.5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17 6H7c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 10H7V8h10v8z"/>
                <rect x="9" y="10" width="6" height="{{ 6 * ($percentage / 100) }}" rx="0.5" />
            </svg>
            <span class="text-sm font-bold {{ $textColor }}">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>
