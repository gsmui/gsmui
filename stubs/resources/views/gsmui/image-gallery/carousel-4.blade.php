@props([
    'images' => [],
    'interval' => 6000,
    'height' => 'h-[600px]',
    'showProgressBar' => true,
])

<div 
    {{ $attributes->class(["relative overflow-hidden rounded-3xl bg-zinc-900"]) }}
    x-data="{ 
        current: 0, 
        total: {{ count($images) }},
        progress: 0
    }"
    x-init="setInterval(() => { current = (current + 1) % total; progress = 0; }, {{ $interval }})"
    x-effect="if(current !== undefined) { progress = 0; let interval = setInterval(() => { progress += 100/{{ $interval }} * 50; if(progress >= 100) clearInterval(interval); }, 50); }"
>
    <div class="relative {{ $height }}">
        @foreach($images as $index => $image)
            <div 
                class="absolute inset-0 transition-opacity duration-1000"
                :class="{ 'opacity-100 z-10': current === {{ $index }}, 'opacity-0 z-0': current !== {{ $index }} }"
            >
                <div class="absolute inset-0 overflow-hidden">
                    <img 
                        src="{{ $image['src'] ?? $image }}" 
                        alt="{{ $image['alt'] ?? 'Slide ' . ($index + 1) }}"
                        class="h-full w-full object-cover scale-110"
                        :class="{ 'animate-kenburns': current === {{ $index }} }"
                    />
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                @if(isset($image['title']))
                    <div class="absolute bottom-12 left-8 right-8">
                        <span class="inline-block rounded-full bg-white/20 px-3 py-1 text-xs font-medium text-white backdrop-blur-sm mb-3">{{ $image['tag'] ?? 'Featured' }}</span>
                        <h2 class="text-3xl font-bold text-white mb-2">{{ $image['title'] }}</h2>
                        <p class="text-lg text-white/70 max-w-xl">{{ $image['description'] ?? '' }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    @if($showProgressBar)
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-white/20">
            <div class="h-full bg-white transition-all duration-100" :style="`width: ${progress}%`"></div>
        </div>
    @endif
</div>

<style>
@keyframes kenburns {
    0% { transform: scale(1.1) translate(0, 0); }
    50% { transform: scale(1.2) translate(-2%, -2%); }
    100% { transform: scale(1.1) translate(0, 0); }
}
.animate-kenburns {
    animation: kenburns {{ $interval }}ms ease-in-out infinite;
}
</style>
