@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'minLabel' => 'Min',
    'maxLabel' => 'Max',
    'showValue' => true,
    'color' => 'blue',
    'units' => '',
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
                <span class="text-lg font-bold text-zinc-900 dark:text-white">
                    <span x-text="value"></span>{{ $units }}
                </span>
            @endif
        </div>
    @endif

    <div class="flex items-center gap-4">
        <span class="text-sm text-zinc-500 dark:text-zinc-400 w-16 text-right">{{ $minLabel }}</span>
        
        <div 
            class="flex-1 relative h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
            @click="
                const rect = $el.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                value = Math.round((x * (max - min) + min) / step) * step;
                value = Math.min(max, Math.max(min, value));
            "
        >
            <div class="absolute h-full {{ $trackColor }} rounded-full" :style="`width: ${percentage}%;`"></div>

            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab active:cursor-grabbing hover:scale-110 transition-transform"
                :style="`left: ${percentage}%;`"
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
            ></div>
        </div>

        <span class="text-sm text-zinc-500 dark:text-zinc-400 w-16">{{ $maxLabel }}</span>
    </div>
</div>
