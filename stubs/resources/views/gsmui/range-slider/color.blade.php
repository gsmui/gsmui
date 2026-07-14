@props([
    'value' => '#3b82f6',
    'label' => null,
    'showValue' => true,
    'saturation' => 100,
    'lightness' => 50,
])

<div 
    {{ $attributes->class(["w-full select-none"]) }}
    x-data="{ 
        hue: {{ (int) hexdec(substr($value, 1, 2)) / 255 * 360 }},
        sat: {{ $saturation }},
        light: {{ $lightness }},
        get color() { return `hsl(${this.hue}, ${this.sat}%, ${this.light}%)`; },
        get hex() {
            const h = this.hue;
            const s = this.sat / 100;
            const l = this.light / 100;
            const a = s * Math.min(l, 1 - l);
            const f = n => {
                const k = (n + h / 30) % 12;
                const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
                return Math.round(255 * color).toString(16).padStart(2, '0');
            };
            return `#${f(0)}${f(8)}${f(4)}`;
        }
    }"
>
    @if($label)
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $label }}</span>
            @if($showValue)
                <span class="text-sm font-mono font-bold text-zinc-900 dark:text-white" x-text="hex"></span>
            @endif
        </div>
    @endif

    {{-- Color Preview --}}
    <div class="flex items-center gap-3 mb-4">
        <div class="w-12 h-12 rounded-xl shadow-inner border border-zinc-200 dark:border-zinc-700" :style="`background-color: ${color};`"></div>
        <div class="flex-1">
            <div class="text-sm font-medium text-zinc-900 dark:text-white" x-text="hex"></div>
            <div class="text-xs text-zinc-500" x-text="`HSL(${Math.round(hue)}, ${sat}%, ${light}%)`"></div>
        </div>
    </div>

    {{-- Hue Slider --}}
    <div class="mb-4">
        <label class="text-xs text-zinc-500 mb-1 block">Hue</label>
        <div 
            class="relative h-4 rounded-full cursor-pointer"
            style="background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000);"
            @click="
                const rect = $el.getBoundingClientRect();
                hue = ((event.clientX - rect.left) / rect.width) * 360;
            "
        >
            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab"
                :style="`left: ${hue / 360 * 100}%;`"
            ></div>
        </div>
    </div>

    {{-- Saturation Slider --}}
    <div class="mb-4">
        <label class="text-xs text-zinc-500 mb-1 block">Saturation</label>
        <div 
            class="relative h-4 rounded-full cursor-pointer"
            :style="`background: linear-gradient(to right, hsl(${hue}, 0%, ${light}%), hsl(${hue}, 100%, ${light}%));`"
            @click="
                const rect = $el.getBoundingClientRect();
                sat = ((event.clientX - rect.left) / rect.width) * 100;
            "
        >
            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab"
                :style="`left: ${sat}%;`"
            ></div>
        </div>
    </div>

    {{-- Lightness Slider --}}
    <div>
        <label class="text-xs text-zinc-500 mb-1 block">Lightness</label>
        <div 
            class="relative h-4 rounded-full cursor-pointer"
            :style="`background: linear-gradient(to right, #000000, hsl(${hue}, ${sat}%, 50%), #ffffff);`"
            @click="
                const rect = $el.getBoundingClientRect();
                light = ((event.clientX - rect.left) / rect.width) * 100;
            "
        >
            <div 
                class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-5 h-5 bg-white rounded-full border-2 border-zinc-300 shadow-md cursor-grab"
                :style="`left: ${light}%;`"
            ></div>
        </div>
    </div>
</div>
