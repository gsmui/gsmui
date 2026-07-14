@props([
    'images' => [],
    'rowHeight' => '180px',
    'gap' => 3,
    'borderColor' => 'blue-500',
    'borderWidth' => '4px',
])

<div {{ $attributes->class(["flex flex-wrap gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-xl border-{{ $borderWidth }} border-transparent hover:border-{{ $borderColor }} transition-all duration-300"
            style="flex: {{ $image['flex'] ?? '1 1 250px' }}; height: {{ $image['height'] ?? $rowHeight }};"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="h-full w-full object-cover"
            />
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="rounded-full bg-white/90 p-2 hover:bg-white shadow-lg">
                    <svg class="h-4 w-4 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
</div>
