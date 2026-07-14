@props([
    'images' => [],
    'gap' => 4,
    'hoverLift' => '16px',
])

<div {{ $attributes->class(["space-y-{-$gap}") }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative rounded-2xl overflow-hidden transition-all duration-500 hover:z-10"
            style="margin-top: {{ $index > 0 ? '-' . ($gap * 4) . 'px' : '0' }};"
        >
            <div class="relative h-64 overflow-hidden">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between transform group-hover:translate-y-[-8px] transition-transform duration-300">
                    <div>
                        <span class="inline-block rounded-full bg-white/20 px-2 py-0.5 text-xs text-white backdrop-blur-sm mb-2">{{ $image['category'] ?? 'Category' }}</span>
                        <h3 class="text-lg font-bold text-white">{{ $image['title'] ?? 'Image ' . ($index + 1) }}</h3>
                    </div>
                    <button class="rounded-full bg-white/90 p-2 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-white">
                        <svg class="h-5 w-5 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
