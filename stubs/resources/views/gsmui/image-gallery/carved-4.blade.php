@props([
    'images' => [],
    'columns' => 3,
    'gap' => 6,
    'metalType' => 'silver',
])

@php
    $metalGradients = [
        'silver' => 'from-zinc-300 via-zinc-100 to-zinc-400',
        'gold' => 'from-yellow-400 via-yellow-200 to-yellow-500',
        'copper' => 'from-orange-400 via-orange-200 to-orange-600',
        'platinum' => 'from-zinc-200 via-white to-zinc-300',
    ];
    $gradient = $metalGradients[$metalType] ?? $metalGradients['silver'];
@endphp

<div {{ $attributes->class(["grid grid-cols-{$columns} gap-{$gap}"]) }}>
    @foreach($images as $index => $image)
        <div class="group relative">
            {{-- Metallic frame --}}
            <div class="relative p-1 rounded-2xl bg-gradient-to-br {{ $gradient }} shadow-xl">
                <div class="relative overflow-hidden rounded-xl bg-zinc-900">
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? '' }}"
                        class="aspect-square w-full object-cover transition-all duration-700 group-hover:scale-110"
                    />
                    {{-- Chrome reflection --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-white/30 via-transparent to-transparent opacity-50 group-hover:opacity-80 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                </div>
                {{-- Metallic edge highlight --}}
                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/30"></div>
            </div>
            <div class="mt-4 px-2">
                <h4 class="font-bold text-zinc-900 dark:text-white">{{ $image['title'] ?? 'Collection' }}</h4>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ $image['series'] ?? 'Premium Series' }}</p>
            </div>
        </div>
    @endforeach
</div>
