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
    'flex items-center gap-3 z-50',
    $positionClass,
    'bg-white/50 dark:bg-zinc-800/50 backdrop-blur-xl rounded-full px-4 py-2',
    'shadow-[0_4px_24px_rgba(0,0,0,0.1)]',
    'border border-white/20 dark:border-white/5',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' 
                          : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-600' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.2 : 1})`">
                <span class="text-base">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
