@props([
    'min' => 0,
    'max' => 100,
    'value' => 75,
    'step' => 1,
    'label' => 'Brightness',
    'showValue' => true,
])

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        value: {{ $value }}, 
        min: {{ $min }}, 
        max: {{ $max }}, 
        step: {{ $step }},
        get percentage() { return ((this.value - this.min) / (this.max - this.min)) * 100; },
        get opacity() { return this.value / 100; }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-sm font-bold text-zinc-900 dark:text-white" x-text="value + '%'"></span>
            @endif
        </div>
    @endif

    <div class="flex items-center gap-4">
        {{-- Sun icon with opacity --}}
        <div class="relative w-8 h-8">
            <svg class="w-8 h-8 text-amber-500 transition-opacity" :style="`opacity: ${opacity};`" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z" />
            </svg>
        </div>

        {{-- Slider --}}
        <div class="flex-1">
            <div 
                class="relative h-3 rounded-full cursor-pointer overflow-hidden"
                style="background: linear-gradient(to right, #1e293b, #fbbf24);"
                @click="
                    const rect = $el.getBoundingClientRect();
                    value = Math.round(((event.clientX - rect.left) / rect.width * (max - min) + min) / step) * step;
                    value = Math.min(max, Math.max(min, value));
                "
            >
                <div 
                    class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-6 h-6 bg-white rounded-full shadow-lg cursor-grab border-2 border-amber-400"
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

        {{-- Dimmed icon --}}
        <div class="relative w-5 h-5">
            <svg class="w-5 h-5 text-zinc-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z" />
            </svg>
        </div>
    </div>
</div>
