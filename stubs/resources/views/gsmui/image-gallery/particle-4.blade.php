@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'pixelSize' => 10,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-2xl bg-zinc-900"
            x-data="{ dissolve: false }"
            @mouseenter="dissolve = true"
            @mouseleave="dissolve = false"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover transition-all duration-500"
                :class="{ 'opacity-0': dissolve, 'scale-110': dissolve }"
                :style="dissolve ? 'filter: blur(20px);' : ''"
            />
            
            {{-- Pixel grid overlay --}}
            <div 
                class="absolute inset-0 pointer-events-none transition-opacity duration-300"
                :class="{ 'opacity-100': dissolve, 'opacity-0': !dissolve }"
            >
                <div class="w-full h-full grid gap-0" style="grid-template-columns: repeat({{ ceil(100 / $pixelSize) }}, 1fr);">
                    @for($i = 0; $i < ceil(100 / $pixelSize) * ceil(100 / $pixelSize); $i++)
                        <div 
                            class="aspect-square transition-all duration-500"
                            style="
                                background-color: hsl({{ rand(0, 360 }}, {{ rand(30, 70) }}%, {{ rand(40, 70) }}%);
                                opacity: {{ rand(20, 60) }}%;
                                animation: pixel-dissolve 1s ease-out {{ $i * 0.01 }}s forwards;
                            "
                        ></div>
                    @endfor
                </div>
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                <div class="absolute bottom-4 left-4 right-4">
                    <h3 class="font-bold text-white">{{ $image['title'] ?? 'Image' }}</h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
@keyframes pixel-dissolve {
    0% { opacity: 1; transform: scale(1); }
    100% { opacity: 0; transform: scale(0.5) translateY(-20px); }
}
</style>
