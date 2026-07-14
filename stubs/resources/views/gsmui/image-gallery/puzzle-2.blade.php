@props([
    'images' => [],
    'size' => '150px',
    'gap' => '8px',
])

<div {{ $attributes->class(["flex flex-wrap justify-center"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden m-1"
            style="width: {{ $size }}; height: {{ $size }}; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-125"
            />
            <div class="absolute inset-0 bg-blue-500/0 group-hover:bg-blue-500/40 transition-colors duration-300 flex items-center justify-center">
                <svg class="h-8 w-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
        </div>
    @endforeach
</div>
