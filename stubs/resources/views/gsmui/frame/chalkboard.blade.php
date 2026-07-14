@props([
    'frame' => true,
    'dust' => true,
])

<div class="relative">
    @if($frame)
    {{-- Wooden frame --}}
    <div class="absolute inset-0 bg-gradient-to-b from-amber-800 via-amber-700 to-amber-800 rounded-lg shadow-xl -m-2"></div>
    @endif
    
    <div {{ $attributes->class([
        'relative bg-zinc-800 dark:bg-zinc-900 rounded-lg p-6',
        $frame ? 'm-2' : '',
    ]) }}>
        {{-- Chalk dust effect --}}
        @if($dust)
        <div class="absolute inset-0 pointer-events-none opacity-5">
            <div class="absolute top-2 left-4 w-16 h-1 bg-white rounded-full transform rotate-12"></div>
            <div class="absolute bottom-4 right-8 w-12 h-1 bg-white rounded-full transform -rotate-6"></div>
        </div>
        @endif
        
        {{ $slot }}
    </div>
</div>
