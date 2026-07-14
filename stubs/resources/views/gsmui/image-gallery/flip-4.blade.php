@props([
    'images' => [],
    'foldCount' => 6,
    'speed' => 0.6,
])

<div 
    {{ $attributes->class(["relative h-[500px] overflow-hidden bg-black"]) }}
    x-data="{ current: 0, total: {{ count($images) }}, animating: false }"
>
    {{-- Current Image --}}
    <img 
        src="{{ $images[0]['src'] ?? $images[0] ?? '' }}" 
        alt=""
        class="absolute inset-0 w-full h-full object-cover"
        :src="`{{ implode(',', array_map(fn($img) => $img['src'] ?? $img, $images)) }}`.split(',')[current]"
    />

    {{-- Fold strips --}}
    <div class="absolute inset-0 flex" x-show="animating">
        @for($i = 0; $i < $foldCount; $i++)
            <div 
                class="flex-1 bg-zinc-900 border-r border-zinc-700"
                style="animation: accordion-fold {{ $speed }}s ease-in-out {{ $i * 0.05 }}s forwards; transform-origin: left;"
            ></div>
        @endfor
    </div>

    <div class="absolute inset-0 flex items-center justify-center">
        <div class="flex gap-4">
            <button 
                @click="animating = true; setTimeout(() => { current = (current - 1 + total) % total; animating = false; }, {{ $speed * 1000 / 2 }});"
                class="rounded-full bg-white/10 backdrop-blur-sm p-4 text-white hover:bg-white/20 transition-colors"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button 
                @click="animating = true; setTimeout(() => { current = (current + 1) % total; animating = false; }, {{ $speed * 1000 / 2 }});"
                class="rounded-full bg-white/10 backdrop-blur-sm p-4 text-white hover:bg-white/20 transition-colors"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>
        </div>
    </div>

    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white text-sm bg-black/50 px-4 py-2 rounded-full backdrop-blur-sm">
        <span x-text="current + 1"></span> / {{ count($images) }}
    </div>
</div>

<style>
@keyframes accordion-fold {
    0% { transform: scaleX(1); opacity: 1; }
    50% { transform: scaleX(0); opacity: 1; }
    100% { transform: scaleX(1); opacity: 0; }
}
</style>
