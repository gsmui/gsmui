@props([
    'min' => 0,
    'max' => 100,
    'value' => 50,
    'step' => 1,
    'label' => null,
    'showValue' => true,
    'color' => 'blue',
    'muted' => false,
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
        muted: {{ $muted ? 'true' : 'false' }},
        get percentage() { return this.muted ? 0 : ((this.value - this.min) / (this.max - this.min)) * 100; }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-sm font-bold text-zinc-900 dark:text-white" x-text="muted ? 'Muted' : value + '%'"></span>
            @endif
        </div>
    @endif

    <div class="flex items-center gap-3">
        {{-- Volume Icon --}}
        <button 
            class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
            @click="muted = !muted"
        >
            <template x-if="!muted && value > 50">
                <svg class="w-5 h-5 text-zinc-700 dark:text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
            </template>
            <template x-if="!muted && value <= 50 && value > 0">
                <svg class="w-5 h-5 text-zinc-700 dark:text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                </svg>
            </template>
            <template x-if="muted || value === 0">
                <svg class="w-5 h-5 text-zinc-700 dark:text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                </svg>
            </template>
        </button>

        {{-- Slider --}}
        <div 
            class="flex-1 relative h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full cursor-pointer"
            @click="
                const rect = $el.getBoundingClientRect();
                value = Math.round(((event.clientX - rect.left) / rect.width * (max - min) + min) / step) * step;
                value = Math.min(max, Math.max(min, value));
                muted = false;
            "
        >
            <div class="absolute h-full {{ $trackColor }} rounded-full" :style="`width: ${percentage}%;`"></div>

            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-4 h-4 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab active:cursor-grabbing hover:scale-125 transition-transform"
                :style="`left: ${percentage}%;`"
                @mousedown.stop="
                    muted = false;
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
