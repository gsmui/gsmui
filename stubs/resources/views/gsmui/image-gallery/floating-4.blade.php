@props([
    'images' => [],
    'columns' => 3,
    'gap' => 4,
    'wingSpan' => 20,
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-2xl"
            x-data="{ hover: false }"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover transition-all duration-700"
                :class="{ 'scale-110': hover }"
            />
            
            {{-- Wing expansion effect --}}
            <div 
                class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-blue-500/30 to-blue-500/0 transition-all duration-500"
                :class="{ 'opacity-100': hover, 'opacity-0': !hover }"
            ></div>

            {{-- Left wing --}}
            <div 
                class="absolute top-0 left-0 bottom-0 w-1/4 bg-gradient-to-r from-black/50 to-transparent transition-all duration-500 origin-left"
                :class="{ '-skew-x-12': hover, 'skew-x-0': !hover }"
            ></div>

            {{-- Right wing --}}
            <div 
                class="absolute top-0 right-0 bottom-0 w-1/4 bg-gradient-to-l from-black/50 to-transparent transition-all duration-500 origin-right"
                :class="{ 'skew-x-12': hover, 'skew-x-0': !hover }"
            ></div>

            <div class="absolute inset-0 flex items-center justify-center">
                <div 
                    class="bg-white/90 rounded-full p-4 transition-all duration-500"
                    :class="{ 'scale-100 opacity-100': hover, 'scale-50 opacity-0': !hover }"
                >
                    <svg class="h-6 w-6 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </div>
            </div>
        </div>
    @endforeach
</div>
