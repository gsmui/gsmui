@props([
    'items' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'hidden sm:flex items-center gap-2 z-50',
    $positionClass,
    'bg-white/90 dark:bg-zinc-800/90 backdrop-blur-xl rounded-2xl p-2 shadow-2xl',
    'border border-zinc-200/50 dark:border-zinc-700/50',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200 ease-[cubic-bezier(0.34,1.56,0.64,1)]
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-200/80 dark:bg-zinc-600/80' 
                          : 'hover:bg-zinc-100/80 dark:hover:bg-zinc-700/80' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-8px' : '0'}) scale(${hovered === {{ $index }} ? 1.2 : 1})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Tooltip --}}
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 px-2.5 py-1.5 bg-zinc-900/95 dark:bg-zinc-700/95 backdrop-blur-sm text-white text-xs font-medium rounded-lg
                        opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none
                        translate-y-1 group-hover:translate-y-0 whitespace-nowrap shadow-xl">
                {{ $item['label'] ?? '' }}
            </div>
        </div>
    @endforeach
</div>
