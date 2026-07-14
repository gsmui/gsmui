@props([
    'items' => [],
    'position' => 'bottom',
    'magnifyStrength' => 1.4,
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-end gap-1 z-50',
    $positionClass,
    'bg-white/90 dark:bg-zinc-800/90 backdrop-blur-2xl rounded-2xl p-2 shadow-2xl border border-zinc-200/50 dark:border-zinc-700/50',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-11 h-11 rounded-[14px] transition-all duration-200 ease-out
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-200 dark:bg-zinc-600' 
                          : 'hover:bg-zinc-100 dark:hover:bg-zinc-700/50' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? {{ $magnifyStrength }} : (Math.abs(hovered - {{ $index }}) === 1 ? 1.2 : Math.abs(hovered - {{ $index }}) === 2 ? 1.05 : 1)})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 px-2 py-1 bg-zinc-900 text-white text-[11px] rounded-lg
                        opacity-0 group-hover:opacity-100 transition-all duration-200 pointer-events-none whitespace-nowrap
                        translate-y-2 group-hover:translate-y-0">
                {{ $item['label'] ?? '' }}
            </div>
        </div>
    @endforeach
</div>
