@props([
    'images' => [],
    'gap' => 6,
    'rotation' => true,
])

<div {{ $attributes->class(["relative min-h-[600px]"]) }}>
    @foreach($images as $index => $image)
        @php
            $positions = [
                'left-[5%] top-[5%] z-10',
                'left-[35%] top-[0%] z-20',
                'right-[5%] top-[8%] z-15',
                'left-[10%] top-[50%] z-25',
                'right-[10%] top-[45%] z-30',
            ];
            $pos = $positions[$index % count($positions)];
            $rotate = $rotation ? ($index % 2 === 0 ? '-rotate-3' : 'rotate-3') : '';
        @endphp
        <div 
            class="absolute {{ $pos }} w-64 {{ $rotate }} group"
            style="transition: transform 0.5s ease;"
        >
            <div class="overflow-hidden rounded-xl shadow-2xl transform group-hover:rotate-0 group-hover:scale-110 group-hover:z-50 transition-all duration-500">
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="w-full h-48 object-cover"
                />
                <div class="bg-white dark:bg-zinc-800 p-3">
                    <h4 class="font-semibold text-zinc-900 dark:text-white text-sm">{{ $image['title'] ?? 'Photo' }}</h4>
                    <p class="text-xs text-zinc-500">{{ $image['date'] ?? '' }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
