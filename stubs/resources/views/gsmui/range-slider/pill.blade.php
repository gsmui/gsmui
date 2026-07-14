@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-emerald-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
    ];
    $trackColor = $colors[$color] ?? $colors['blue'];
@endphp

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        value: {{ $value }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-lg font-bold text-zinc-900 dark:text-white" x-text="value"></span>
            @endif
        </div>
    @endif

    <div 
        class="relative h-6 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
        @click="
            const rect = $el.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width;
            value = Math.round((x * (max - min) + min) / step) * step;
            value = Math.min(max, Math.max(min, value));
        "
    >
        <div class="absolute inset-y-1 left-1 {{ $trackColor }} rounded-full transition-all duration-150" :style="`width: calc(${percentage}% - 8px);`"></div>

        <div 
            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-8 h-8 bg-white rounded-full shadow-lg cursor-grab active:cursor-grabbing hover:scale-105 transition-transform border border-zinc-200 dark:border-zinc-600"
            :style="`left: calc(${percentage}% + 4px);`"
            @mousedown.stop="
                const rect = $el.parentElement.getBoundingClientRect();
                const onMove = (e) => {
                    const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                    value = Math.round((x * (max - min) + min) / step) * step;
                    value = Math.min(max, Math.max(min, value));
                };
                const onUp = () => { document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
                document.addEventListener('mousemove', onMove);
                document.addEventListener('mouseup', onUp);
            "
        >
            <div class="absolute inset-2 flex items-center justify-center">
                <div class="w-1.5 h-1.5 rounded-full bg-zinc-400"></div>
                <div class="w-1.5 h-1.5 rounded-full bg-zinc-400 ml-1"></div>
            </div>
        </div>
    </div>
</div>
