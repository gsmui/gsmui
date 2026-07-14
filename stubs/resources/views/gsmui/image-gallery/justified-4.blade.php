@props([
    'images' => [],
    'gap' => 2,
    'maxHeight' => '300px',
])

<div {{ $attributes->class(["flex flex-wrap items-start gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-lg"
            style="flex: {{ $image['flex'] ?? '1 1 200px' }}; height: {{ isset($image['height']) ? min($image['height'], 300) : rand(150, 300) }}px;"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110 group-hover:shadow-xl"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center">
                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 transition-all duration-300">
                    <button class="rounded-full bg-white p-2 hover:bg-white/90 shadow-lg">
                        <svg class="h-5 w-5 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </button>
                    <button class="rounded-full bg-white p-2 hover:bg-white/90 shadow-lg">
                        <svg class="h-5 w-5 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
