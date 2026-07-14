@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => 'Temperature',
    'showValue' => true,
    'unit' => '°',
    'minColor' => '#3b82f6',
    'maxColor' => '#ef4444',
])

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        value: {{ $value }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; },
        get color() { 
            const ratio = this.percentage / 100;
            if (ratio < 0.5) {
                const r = Math.round(59 + (249 - 59) * ratio * 2);
                const g = Math.round(130 + (115 - 130) * ratio * 2);
                const b = Math.round(246 + (22 - 246) * ratio * 2);
                return `rgb(${r}, ${g}, ${b})`;
            } else {
                const r = Math.round(249 + (239 - 249) * (ratio - 0.5) * 2);
                const g = Math.round(115 + (68 - 115) * (ratio - 0.5) * 2);
                const b = Math.round(22 + (68 - 22) * (ratio - 0.5) * 2);
                return `rgb(${r}, ${g}, ${b})`;
            }
        }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-2xl font-bold" :style="`color: ${color};`">
                    <span x-text="value"></span>{{ $unit }}
                </span>
            @endif
        </div>
    @endif

    {{-- Thermometer icon --}}
    <div class="flex items-center gap-4 mb-4">
        <div class="w-8 h-20 bg-zinc-200 dark:bg-zinc-700 rounded-full relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 rounded-full transition-all duration-150" :style="`height: ${percentage}%; background-color: ${color};`"></div>
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-white/80 border border-zinc-300"></div>
        </div>
        <div class="flex-1">
            <div class="flex justify-between text-xs text-zinc-500 mb-1">
                <span>{{ $min }}{{ $unit }}</span>
                <span>{{ $max }}{{ $unit }}</span>
            </div>
            <div 
                class="relative h-3 rounded-full cursor-pointer"
                style="background: linear-gradient(to right, #3b82f6, #f59e0b, #ef4444);"
                @click="
                    const rect = $el.getBoundingClientRect();
                    value = Math.round(((event.clientX - rect.left) / rect.width * (max - min) + min) / step) * step;
                    value = Math.min(max, Math.max(min, value));
                "
            >
                <div 
                    class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-6 h-6 bg-white rounded-full shadow-lg cursor-grab border-2 border-zinc-300"
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
        </div>
    </div>
</div>
