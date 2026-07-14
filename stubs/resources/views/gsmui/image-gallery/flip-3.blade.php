@props([
    'images' => [],
    'panels' => 4,
    'direction' => 'right',
])

<div 
    {{ $attributes->class(["relative h-96 overflow-hidden"]) }}
    x-data="{ current: 0, total: {{ count($images) }}, folding: false }"
>
    @foreach($images as $index => $image)
        <div 
            class="absolute inset-0"
            x-show="current === {{ $index }}"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        >
            <img src="{{ $image['src'] ?? $image }}" alt="" class="w-full h-full object-cover" />
        </div>
    @endforeach

    {{-- Fold overlay --}}
    <div class="absolute inset-0 pointer-events-none" x-show="folding">
        @for($i = 0; $i < $panels; $i++)
            <div 
                class="absolute top-0 bottom-0 bg-zinc-900 origin-{{ $direction }}"
                style="
                    width: {{ 100 / $panels }}%;
                    left: {{ ($i * 100) / $panels }}%;
                    transform-origin: {{ $direction }};
                    animation: fold-panel 0.7s ease-in-out {{ $i * 0.1 }}s forwards;
                "
            ></div>
        @endfor
    </div>

    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3">
        <button @click="folding = true; setTimeout(() => { current = (current - 1 + total) % total; folding = false; }, 350)" class="rounded-full bg-white/90 p-3 shadow-lg hover:bg-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        </button>
        <button @click="folding = true; setTimeout(() => { current = (current + 1) % total; folding = false; }, 350)" class="rounded-full bg-white/90 p-3 shadow-lg hover:bg-white transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </button>
    </div>
</div>

<style>
@keyframes fold-panel {
    0% { transform: rotateY(0deg); }
    50% { transform: rotateY(-90deg); }
    100% { transform: rotateY(0deg); opacity: 0; }
}
</style>
