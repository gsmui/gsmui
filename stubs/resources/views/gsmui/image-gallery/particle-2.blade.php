@props([
    'images' => [],
    'columns' => 4,
    'gap' => 2,
    'particleDensity' => 'medium',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden aspect-square">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            
            {{-- Floating particles overlay --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                @for($i = 0; $i < 15; $i++)
                    <div 
                        class="absolute rounded-full bg-white/40"
                        style="
                            width: {{ rand(2, 8) }}px;
                            height: {{ rand(2, 8) }}px;
                            left: {{ rand(0, 100) }}%;
                            animation: particle-float {{ rand(3, 7) }}s ease-in-out infinite;
                            animation-delay: {{ $i * 0.3 }}s;
                        "
                    ></div>
                @endfor
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-4 left-4 right-4 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="font-bold text-white">{{ $image['title'] ?? 'Image' }}</h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
@keyframes particle-float {
    0%, 100% { transform: translateY(0) translateX(0) scale(1); opacity: 0.4; }
    25% { transform: translateY(-20px) translateX(10px) scale(1.2); opacity: 0.8; }
    50% { transform: translateY(-10px) translateX(-5px) scale(0.8); opacity: 0.6; }
    75% { transform: translateY(-30px) translateX(-10px) scale(1.1); opacity: 0.9; }
}
</style>
