@props([
    'images' => [],
    'columns' => 4,
    'gap' => 2,
    'borderRadius' => 'rounded-2xl',
])

<div {{ $attributes->class(["columns-{$columns} gap-{$gap} space-y-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden {{ $borderRadius }}">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Gallery ' . ($index + 1) }}"
                class="w-full object-cover transition-all duration-500 group-hover:brightness-110 group-hover:contrast-110"
                style="{{ isset($image['height']) ? 'height: ' . $image['height'] : '' }}"
            />
            <div class="absolute inset-0 ring-1 ring-inset ring-white/10 {{ $borderRadius }}"></div>
            <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100 bg-black/30">
                <div class="flex gap-2">
                    <button class="rounded-full bg-white/90 p-2 hover:bg-white transition-colors">
                        <svg class="h-5 w-5 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </button>
                    <button class="rounded-full bg-white/90 p-2 hover:bg-white transition-colors">
                        <svg class="h-5 w-5 text-zinc-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
