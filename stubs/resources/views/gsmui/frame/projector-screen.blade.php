@props([
    'pull' => true,
    'mounted' => false,
])

<div class="relative">
    @if($pull || $mounted)
    {{-- Mounting bracket --}}
    <div class="bg-zinc-800 h-3 rounded-t-lg mx-auto w-2/3"></div>
    @endif
    
    {{-- Screen --}}
    <div {{ $attributes->class([
        'bg-zinc-900 rounded-lg overflow-hidden',
        'border-4 border-zinc-700',
        'shadow-2xl',
    ]) }}>
        <div class="bg-white dark:bg-zinc-800 dark:bg-zinc-950">
            {{ $slot }}
        </div>
    </div>
    
    @if($pull)
    {{-- Pull cord --}}
    <div class="absolute -bottom-8 left-1/2 -translate-x-1/2">
        <div class="w-px h-8 bg-zinc-400"></div>
        <div class="w-3 h-3 bg-zinc-600 rounded-full mx-auto -mt-1"></div>
    </div>
    @endif
</div>
