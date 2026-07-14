@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'mistColor' => 'rgba(147, 197, 253, 0.3)',
])

<div {{ $attributes->class(["relative grid grid-cols-{$columns} gap-{$gap}"]) }}>
    {{-- Background mist --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        @for($i = 0; $i < 8; $i++)
            <div 
                class="absolute rounded-full"
                style="
                    width: {{ rand(200, 400) }}px;
                    height: {{ rand(200, 400) }}px;
                    left: {{ rand(0, 100) }}%;
                    top: {{ rand(0, 100) }}%;
                    background: {{ $mistColor }};
                    filter: blur(60px);
                    animation: mist-drift {{ rand(8, 15) }}s ease-in-out infinite;
                    animation-delay: {{ $i * 2 }}s;
                "
            ></div>
        @endfor
    </div>

    @foreach($images as $index => $image)
        <div 
            class="group relative z-10"
            style="animation: ethereal-float {{ 5 + $index }}s ease-in-out infinite; animation-delay: {{ $index * 0.5 }}s;"
        >
            <div class="relative overflow-hidden rounded-3xl bg-white/10 backdrop-blur-sm border border-white/20 shadow-xl">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="aspect-[4/5] w-full object-cover transition-all duration-700 group-hover:scale-105 group-hover:brightness-110"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/60 via-transparent to-purple-900/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500">
                    <h3 class="text-lg font-bold text-white">{{ $image['title'] ?? 'Image' }}</h3>
                    <p class="text-sm text-white/70 mt-1">{{ $image['description'] ?? '' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
@keyframes ethereal-float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-15px) scale(1.02); }
}
@keyframes mist-drift {
    0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
    33% { transform: translate(30px, -20px) scale(1.1); opacity: 0.5; }
    66% { transform: translate(-20px, 20px) scale(0.9); opacity: 0.4; }
}
</style>
