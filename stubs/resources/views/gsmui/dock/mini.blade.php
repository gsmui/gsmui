@props([
    'items' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-2 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-2 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-2 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center gap-1 z-50',
    $positionClass,
    'bg-white/90 dark:bg-zinc-800/90 backdrop-blur-lg rounded-xl p-1 shadow-lg border border-zinc-200/50 dark:border-zinc-700/50',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-400 dark:text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.2 : 1})`">
                <span class="text-sm">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
