@props([
    'images' => [],
    'rowHeight' => '200px',
    'gap' => 2,
    'hoverEffect' => true,
])

<div {{ $attributes->class(["flex flex-wrap gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div 
            class="group relative overflow-hidden rounded-lg"
            style="flex: {{ $image['flex'] ?? '1 1 auto' }}; min-width: 200px; height: {{ $image['height'] ?? $rowHeight }};"
        >
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? 'Justified image ' . ($index + 1) }}"
                class="h-full w-full object-cover transition-transform duration-500 {{ $hoverEffect ? 'group-hover:scale-110' : '' }}"
            />
            @if(isset($image['caption']))
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <div class="absolute bottom-3 left-3 right-3">
                        <p class="text-sm font-medium text-white">{{ $image['caption'] }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
