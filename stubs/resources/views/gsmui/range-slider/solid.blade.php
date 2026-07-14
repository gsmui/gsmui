@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
    'trackHeight' => 'h-4',
])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-emerald-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
        'orange' => 'bg-orange-500',
        'pink' => 'bg-pink-500',
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
        class="relative {{ $trackHeight }} rounded-full cursor-pointer overflow-hidden"
        @click="
            const rect = $el.getBoundingClientRect();
            const x = (event.clientX - rect.left) / rect.width;
            value = Math.round((x * (max - min) + min) / step) * step;
            value = Math.min(max, Math.max(min, value));
        "
        @mousedown="
            const rect = $el.getBoundingClientRect();
            const updateValue = (e) => {
                const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                value = Math.round((x * (max - min) + min) / step) * step;
                value = Math.min(max, Math.max(min, value));
            };
            updateValue(event);
            const onMove = (e) => updateValue(e);
            const onUp = () => { document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
            document.addEventListener('mousemove', onMove);
            document.addEventListener('mouseup', onUp);
        "
    >
        <div class="absolute inset-0 bg-zinc-200 dark:bg-zinc-700 rounded-full"></div>
        <div class="absolute inset-y-0 left-0 {{ $trackColor }} rounded-full transition-all duration-150" :style="`width: ${percentage}%;`"></div>

        <div 
            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-6 h-6 bg-white rounded-full shadow-lg cursor-grab active:cursor-grabbing hover:scale-110 transition-transform border-2 border-zinc-300"
            :style="`left: ${percentage}%;`"
        ></div>
    </div>
</div>
