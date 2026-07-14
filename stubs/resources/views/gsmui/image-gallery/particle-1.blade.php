@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'particleCount' => 50,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-2xl bg-zinc-900"
            x-data="{ particles: Array.from({length: {{ $particleCount }}, (_, i) => ({ x: Math.random() * 100, y: Math.random() * 100, size: Math.random() * 4 + 2, delay: Math.random() * 0.5 })) }"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover transition-all duration-700 group-hover:opacity-0 group-hover:scale-110"
            />
            
            {{-- Particles --}}
            <div class="absolute inset-0 pointer-events-none">
                @foreach(range(1, $particleCount) as $i)
                    <div 
                        class="absolute rounded-full bg-white/80"
                        style="
                            width: {{ rand(2, 6) }}px;
                            height: {{ rand(2, 6) }}px;
                            left: {{ rand(5, 95) }}%;
                            top: {{ rand(5, 95) }}%;
                            opacity: 0;
                            transition: all 0.8s ease-out;
                            transition-delay: {{ $i * 0.02 }}s;
                        "
                    ></div>
                @endforeach
            </div>

            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                <span class="text-white font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-500">{{ $image['title'] ?? 'View' }}</span>
            </div>
        </div>
    @endforeach
</div>
