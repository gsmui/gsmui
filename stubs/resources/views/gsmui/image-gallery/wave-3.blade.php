@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'waveColor' => '#3b82f6',
])

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative overflow-hidden rounded-2xl">
            <img 
                src="{{ $image['src'] ?? $image }}" 
                alt="{{ $image['alt'] ?? '' }}"
                class="aspect-square w-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
            
            {{-- Wave border at bottom --}}
            <div class="absolute bottom-0 left-0 right-0 overflow-hidden">
                <svg class="w-full" viewBox="0 0 400 50" preserveAspectRatio="none" style="height: 30px;">
                    <path fill="{{ $waveColor }}" fill-opacity="0.8">
                        <animate 
                            attributeName="d" 
                            dur="3s" 
                            repeatCount="indefinite" 
                            values="M0,25 C100,50 200,0 300,25 C350,35 380,30 400,25 L400,50 L0,50 Z;M0,25 C100,0 200,50 300,25 C350,15 380,20 400,25 L400,50 L0,50 Z;M0,25 C100,50 200,0 300,25 C350,35 380,30 400,25 L400,50 L0,50 Z"
                        />
                    </path>
                </svg>
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                <div class="absolute bottom-8 left-4 right-4">
                    <h3 class="font-bold text-white text-lg">{{ $image['title'] ?? 'Image' }}</h3>
                    <p class="text-sm text-white/70">{{ $image['subtitle'] ?? '' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
