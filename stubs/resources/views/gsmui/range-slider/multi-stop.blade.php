@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'stops' => [
        ['position' => 0, 'color' => '#ef4444'],
        ['position' => 50, 'color' => '#f59e0b'],
        ['position' => 100, 'color' => '#22c55e'],
    ],
])

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        value: {{ $value }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        stops: {{ json_encode($stops) }},
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; },
        get gradient() { 
            return this.stops.map(s => s.color).join(', ');
        }
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

    {{-- Stop indicators --}}
    <div class="relative mb-2">
        @foreach($stops as $stop)
            <div 
                class="absolute -translate-x-1/2 flex flex-col items-center"
                :style="`left: {{ $stop['position'] }}%;`"
            >
                <div class="w-2 h-2 rounded-full" :style="`background-color: {{ $stop['color'] }};`"></div>
            </div>
        @endforeach
    </div>

    <div 
        class="relative h-4 rounded-full cursor-pointer overflow-hidden"
        :style="`background: linear-gradient(to right, ${gradient});`"
        @click="
            const rect = $el.getBoundingClientRect();
            value = Math.round(((event.clientX - rect.left) / rect.width * (max - min) + min) / step) * step;
            value = Math.min(max, Math.max(min, value));
        "
    >
        <div 
            class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-6 h-6 bg-white rounded-full shadow-lg cursor-grab border-2 border-zinc-300 hover:scale-110 transition-transform"
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
