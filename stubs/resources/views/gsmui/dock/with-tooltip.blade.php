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
    'flex items-center gap-2 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/25' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-4px' : '0'})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Tooltip --}}
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2.5 py-1.5 bg-zinc-900 dark:bg-zinc-700 text-white text-xs font-medium rounded-lg
                        opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none
                        translate-y-1 group-hover:translate-y-0 whitespace-nowrap shadow-lg">
                {{ $item['label'] ?? '' }}
                <div class="absolute top-full left-1/2 -translate-x-1/2 w-2 h-2 bg-zinc-900 dark:bg-zinc-700 rotate-45 -mt-1"></div>
            </div>
        </div>
    @endforeach
</div>
