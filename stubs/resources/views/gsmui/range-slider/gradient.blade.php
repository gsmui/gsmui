@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'gradientFrom' => '#ef4444',
    'gradientVia' => '#f59e0b',
    'gradientTo' => '#22c55e',
])

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ value: {{ $value }}, min: {{ $min }}, max: {{ $max }}, step: {{ $step }} }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-sm font-bold text-zinc-900 dark:text-white" x-text="value"></span>
            @endif
        </div>
    @endif

    <div 
        class="relative h-3 rounded-full cursor-pointer"
        style="background: linear-gradient(to right, {{ $gradientFrom }}, {{ $gradientVia }}, {{ $gradientTo }});"
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
        <div 
            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-6 h-6 bg-white rounded-full border-4 border-zinc-300 shadow-lg cursor-grab active:cursor-grabbing hover:scale-110 transition-transform"
            :style="`left: ${(value - min) / (max - min) * 100}%;`"
        ></div>
    </div>

    @if(!$label)
        @if($showValues)
            <div class="flex justify-between mt-2 text-xs text-zinc-500">
                <span x-text="min"></span>
                <span class="font-bold text-zinc-900 dark:text-white" x-text="value"></span>
                <span x-text="max"></span>
            </div>
        @endif
    @endif
</div>
