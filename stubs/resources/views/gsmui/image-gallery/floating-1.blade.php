@props([
    'images' => [],
    'columns' => 3,
    'gap' => 8,
    'floatSpeed' => 4,
    'glowColor' => 'rgba(255, 255, 255, 0.3)',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap} py-12"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative"
            style="animation: angel-float {{ $floatSpeed + ($index * 0.5) }}s ease-in-out infinite; animation-delay: {{ $index * 0.3 }}s;"
        >
            <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="aspect-[3/4] w-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                    <h3 class="text-xl font-bold text-white mb-1">{{ $image['title'] ?? 'Image' }}</h3>
                    <p class="text-sm text-white/70">{{ $image['subtitle'] ?? '' }}</p>
                </div>
            </div>
            {{-- Angel glow effect --}}
            <div 
                class="absolute -inset-4 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10 blur-xl"
                style="background: {{ $glowColor }};"
            ></div>
            {{-- Floating particles --}}
            @for($i = 0; $i < 5; $i++)
                <div 
                    class="absolute w-1 h-1 rounded-full bg-white/60"
                    style="
                        left: {{ 20 + ($i * 15) }}%;
                        top: {{ rand(10, 80) }}%;
                        animation: particle-drift {{ 2 + $i }}s ease-in-out infinite;
                        animation-delay: {{ $i * 0.4 }}s;
                    "
                ></div>
            @endfor
        </div>
    @endforeach
</div>

<style>
@keyframes angel-float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    25% { transform: translateY(-20px) rotate(1deg); }
    50% { transform: translateY(-10px) rotate(-1deg); }
    75% { transform: translateY(-25px) rotate(0.5deg); }
}
@keyframes particle-drift {
    0%, 100% { transform: translateY(0) translateX(0); opacity: 0.6; }
    50% { transform: translateY(-30px) translateX(10px); opacity: 1; }
}
</style>
