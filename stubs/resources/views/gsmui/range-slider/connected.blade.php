@props([
    'sliders' => [
        ['label' => 'Width', 'min' => 0, 'max' => 100, 'value' => 75, 'color' => 'blue', 'unit' => 'px'],
        ['label' => 'Height', 'min' => 0, 'max' => 100, 'value' => 50, 'color' => 'green', 'unit' => 'px'],
        ['label' => 'Opacity', 'min' => 0, 'max' => 100, 'value' => 100, 'color' => 'purple', 'unit' => '%'],
    ],
    'step' => 1,
    'linkValues' => false,
])

@php
    $colors = [
        'blue' => ['track' => 'bg-blue-500', 'border' => 'border-blue-500'],
        'green' => ['track' => 'bg-emerald-500', 'border' => 'border-emerald-500'],
        'red' => ['track' => 'bg-red-500', 'border' => 'border-red-500'],
        'purple' => ['track' => 'bg-purple-500', 'border' => 'border-purple-500'],
        'orange' => ['track' => 'bg-orange-500', 'border' => 'border-orange-500'],
    ];
@endphp

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        sliders: {{ json_encode($sliders) }},
        step: {{ $step }},
        linkValues: {{ $linkValues ? 'true' : 'false' }},
        updateValue(index, newValue) {
            this.sliders[index].value = Math.min(this.sliders[index].max, Math.max(this.sliders[index].min, newValue));
            if (this.linkValues) {
                const ratio = this.sliders[index].value / this.sliders[index].max;
                this.sliders.forEach((s, i) => {
                    if (i !== index) {
                        s.value = Math.round(ratio * s.max / this.step) * this.step;
                    }
                });
            }
        }
    }"
>
    {{-- Preview box --}}
    <div class="mb-6 p-4 bg-zinc-100 dark:bg-zinc-800 rounded-xl">
        <div 
            class="bg-blue-500 rounded-lg transition-all duration-150 mx-auto"
            :style="`width: ${sliders[0].value}${sliders[0].unit}; height: ${sliders[1].value}${sliders[1].unit}; opacity: ${sliders[2].value / 100};`"
        ></div>
    </div>

    <div class="space-y-4">
        @foreach($sliders as $index => $slider)
            @php
                $colorSet = $colors[$slider['color']] ?? $colors['blue'];
            @endphp
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $slider['label'] }}</span>
                    <span class="text-sm font-bold text-zinc-900 dark:text-white">
                        <span x-text="sliders[{{ $index }}].value"></span>{{ $slider['unit'] }}
                    </span>
                </div>
                <div 
                    class="relative h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
                    @click="
                        const rect = $el.getBoundingClientRect();
                        const x = (event.clientX - rect.left) / rect.width;
                        const newValue = Math.round((x * (sliders[{{ $index }}].max - sliders[{{ $index }}].min) + sliders[{{ $index }}].min) / step) * step;
                        updateValue({{ $index }}, newValue);
                    "
                >
                    <div class="absolute h-full {{ $colorSet['track'] }} rounded-full transition-all duration-150" :style="`width: ${(sliders[{{ $index }}].value - sliders[{{ $index }}].min) / (sliders[{{ $index }}].max - sliders[{{ $index }}].min) * 100}%;`"></div>
                    <div 
                        class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab hover:scale-110 transition-transform z-10"
                        :style="`left: ${(sliders[{{ $index }}].value - sliders[{{ $index }}].min) / (sliders[{{ $index }}].max - sliders[{{ $index }}].min) * 100}%;`"
                        @mousedown.stop="
                            const rect = $el.parentElement.getBoundingClientRect();
                            const idx = {{ $index }};
                            const onMove = (e) => {
                                const x = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
                                const newValue = Math.round((x * (sliders[idx].max - sliders[idx].min) + sliders[idx].min) / step) * step;
                                updateValue(idx, newValue);
                            };
                            const onUp = () => { document.removeEventListener('mousemove', onMove); document.removeEventListener('mouseup', onUp); };
                            document.addEventListener('mousemove', onMove);
                            document.addEventListener('mouseup', onUp);
                        "
                    ></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
