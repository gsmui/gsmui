@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 25,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
    'showSteps' => true,
])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-emerald-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
    ];
    $trackColor = $colors[$color] ?? $colors['blue'];
    $steps = range($min, $max, $step);
    $stepIndex = array_search($value, $steps);
@endphp

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        value: {{ $value }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        steps: {{ json_encode($steps) }},
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-4">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-lg font-bold text-zinc-900 dark:text-white" x-text="value"></span>
            @endif
        </div>
    @endif

    <div class="relative">
        <div 
            class="relative h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
            @click="
                const rect = $el.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                const rawValue = x * (max - min) + min;
                const stepIndex = Math.round((rawValue - min) / step);
                value = steps[Math.min(stepIndex, steps.length - 1)];
            "
        >
            <div class="absolute h-full {{ $trackColor }} rounded-full transition-all duration-150" :style="`width: ${percentage}%;`"></div>
        </div>

        @if($showSteps)
            <div class="flex justify-between mt-3">
                @foreach($steps as $stepValue)
                    <button 
                        class="flex flex-col items-center"
                        @click="value = {{ $stepValue }}"
                    >
                        <div 
                            class="w-3 h-3 rounded-full border-2 transition-all duration-150"
                            :class="value >= {{ $stepValue }} ? '{{ $trackColor }} border-transparent' : 'bg-white border-zinc-300 dark:border-zinc-600'"
                        ></div>
                        <span class="text-xs text-zinc-500 mt-1">{{ $stepValue }}</span>
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>
