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
    'bg-gradient-to-b from-zinc-300 to-zinc-400 dark:from-zinc-600 dark:to-zinc-700',
    'rounded-2xl p-[3px] shadow-2xl',
]) }}
    x-data="{ hovered: null }">
    
    <div class="flex items-center gap-2 bg-gradient-to-b from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900 rounded-[13px] p-2">
        @foreach($items as $index => $item)
            <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-gradient-to-b from-zinc-500 to-zinc-600 text-white shadow-inner' 
                              : 'bg-gradient-to-b from-white/50 to-zinc-100/50 dark:from-zinc-700/50 dark:to-zinc-800/50 text-zinc-600 dark:text-zinc-300 hover:from-zinc-200 hover:to-zinc-300 dark:hover:from-zinc-600 dark:hover:to-zinc-700' }}"
                   :style="`transform: translateY(${hovered === {{ $index }} ? '-2px' : '0'})`">
                    <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
