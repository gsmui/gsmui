@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
    'size' => 150,
    'strokeWidth' => 10,
])

@php
    $colors = [
        'blue' => ['#track' => '#3b82f6', 'text' => 'text-blue-500'],
        'green' => ['#track' => '#10b981', 'text' => 'text-emerald-500'],
        'red' => ['#track' => '#ef4444', 'text' => 'text-red-500'],
        'purple' => ['#track' => '#8b5cf6', 'text' => 'text-purple-500'],
    ];
    $colorSet = $colors[$color] ?? $colors['blue'];
    $radius = ($size - $strokeWidth) / 2;
    $circumference = 2 * pi() * $radius;
@endphp

<div 
    {{ $attributes->class(["inline-flex flex-col items-center select-none"]) }}
    x-data="{ 
        value: {{ $value }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; },
        get offset() { return {{ $circumference }} - (this.percentage / 100) * {{ $circumference }}; }
    }"
>
    @if($label)
        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">{{ $label }}</span>
    @endif

    <div class="relative" style="width: {{ $size }}px; height: {{ $size }}px;">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 {{ $size }} {{ $size }}">
            {{-- Background circle --}}
            <circle 
                cx="{{ $size / 2 }}" 
                cy="{{ $size / 2 }}" 
                r="{{ $radius }}"
                fill="none"
                stroke="currentColor"
                class="text-zinc-200 dark:text-zinc-700"
                stroke-width="{{ $strokeWidth }}"
            />
            {{-- Value circle --}}
            <circle 
                cx="{{ $size / 2 }}" 
                cy="{{ $size / 2 }}" 
                r="{{ $radius }}"
                fill="none"
                stroke="{{ $colorSet['#track'] }}"
                stroke-width="{{ $strokeWidth }}"
                stroke-linecap="round"
                :stroke-dasharray="{{ $circumference }}"
                :stroke-dashoffset="offset"
                class="transition-all duration-150"
            />
        </svg>

        {{-- Center content --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center">
            @if($showValue)
                <span class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="value"></span>
            @endif
        </div>

        {{-- Thumb --}}
        <div 
            class="absolute w-4 h-4 bg-white rounded-full border-4 shadow-lg cursor-grab"
            :style="`
                border-color: {{ $colorSet['#track'] }};
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(${-90 + (percentage / 100) * 360}deg) translateY(-{{ $radius }}px);
            `"
        ></div>
    </div>

    {{-- Slider bar below --}}
    <div class="w-full mt-4">
        <div 
            class="relative h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
            @click="
                const rect = $el.getBoundingClientRect();
                value = Math.round(((event.clientX - rect.left) / rect.width * (max - min) + min) / step) * step;
                value = Math.min(max, Math.max(min, value));
            "
        >
            <div class="absolute h-full rounded-full" :style="`width: ${percentage}%; background-color: {{ $colorSet['#track'] }};`"></div>
            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-4 h-4 bg-white rounded-full border-2 shadow cursor-grab"
                :style="`left: ${percentage}%; border-color: {{ $colorSet['#track'] }};`"
            ></div>
        </div>
    </div>
</div>
