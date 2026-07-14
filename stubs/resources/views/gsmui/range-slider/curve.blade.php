@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
    'size' => 200,
    'strokeWidth' => 12,
])

@php
    $colors = [
        'blue' => '#3b82f6',
        'green' => '#10b981',
        'red' => '#ef4444',
        'purple' => '#8b5cf6',
        'orange' => '#f97316',
    ];
    $strokeColor = $colors[$color] ?? $colors['blue'];
    $radius = ($size - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
    $percentage = (($value - $min) / ($max - $min)) * 100;
    $offset = $circumference - ($percentage / 100) * $circumference * 0.75;
@endphp

<div 
    {{ $attributes->class(["relative inline-flex flex-col items-center gap-2 select-none"]) }}
    x-data="{ value: {{ $value }}, min: {{ $min }}, max: {{ $max }}, step: {{ $step }} }"
>
    @if($label)
        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
    @endif

    <div class="relative" style="width: {{ $size }}px; height: {{ $size * 0.7 }}px;">
        <svg class="w-full h-full" viewBox="0 0 {{ $size }} {{ $size * 0.7 }}">
            {{-- Background arc --}}
            <path 
                d="M {{ $strokeWidth / 2 }} {{ $size * 0.6 }} A {{ $radius }} {{ $radius }} 0 1 1 {{ $size - $strokeWidth / 2 }} {{ $size * 0.6 }}"
                fill="none"
                stroke="currentColor"
                class="text-zinc-200 dark:text-zinc-700"
                stroke-width="{{ $strokeWidth }}"
                stroke-linecap="round"
            />
            {{-- Value arc --}}
            <path 
                d="M {{ $strokeWidth / 2 }} {{ $size * 0.6 }} A {{ $radius }} {{ $radius }} 0 1 1 {{ $size - $strokeWidth / 2 }} {{ $size * 0.6 }}"
                fill="none"
                stroke="{{ $strokeColor }}"
                stroke-width="{{ $strokeWidth }}"
                stroke-linecap="round"
                :stroke-dasharray="{{ $circumference }}"
                :stroke-dashoffset="{{ $circumference }} - (value - min) / (max - min) * {{ $circumference * 0.75 }}"
                class="transition-all duration-150"
            />
        </svg>

        {{-- Thumb --}}
        <div 
            class="absolute w-6 h-6 bg-white rounded-full border-4 shadow-lg cursor-grab active:cursor-grabbing transition-transform hover:scale-110"
            :style="`
                border-color: {{ $strokeColor }};
                left: 50%;
                bottom: 0;
                transform: translateX(-50%) rotate(${-135 + (value - min) / (max - min) * 270}deg) translateY(-${{ $radius }}px) rotate(${-(-135 + (value - min) / (max - min) * 270)}deg);
            `"
        ></div>

        @if($showValue)
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-4">
                <span class="text-xl font-bold text-zinc-900 dark:text-white" x-text="value"></span>
            </div>
        @endif
    </div>
</div>
