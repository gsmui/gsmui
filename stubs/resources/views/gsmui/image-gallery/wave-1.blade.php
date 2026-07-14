@props([
    'images' => [],
    'waveHeight' => 100,
    'waveSpeed' => 3,
    'columns' => 3,
])

<div {{ $attributes->class(["relative overflow-hidden bg-gradient-to-b from-zinc-900 to-zinc-800 py-20"]) }}>
    {{-- Wave background --}}
    <div class="absolute bottom-0 left-0 right-0 overflow-hidden">
        <svg class="w-full" viewBox="0 0 1440 320" preserveAspectRatio="none" style="height: {{ $waveHeight }}px;">
            <path fill="rgba(59, 130, 246, 0.1)" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                <animate attributeName="d" dur="{{ $waveSpeed }}s" repeatCount="indefinite" values="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z;M0,160L48,170.7C96,181,192,203,288,213.3C384,224,480,224,576,208C672,192,768,160,864,165.3C960,171,1056,213,1152,218.7C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z;M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" />
            </path>
        </svg>
    </div>

    <div class="relative grid grid-cols-{{ $columns }} gap-6 px-8">
        @foreach($images as $index => $image)
            <div 
                class="group relative overflow-hidden rounded-2xl"
                style="animation: wave-float {{ 3 + $index * 0.5 }}s ease-in-out infinite; animation-delay: {{ $index * 0.2 }}s;"
            >
                <img 
                    src="{{ $image['src'] ?? $image }}" 
                    alt="{{ $image['alt'] ?? '' }}"
                    class="aspect-[4/3] w-full object-cover transition-transform duration-700 group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="font-bold text-white">{{ $image['title'] ?? 'Image' }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
@keyframes wave-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}
</style>
