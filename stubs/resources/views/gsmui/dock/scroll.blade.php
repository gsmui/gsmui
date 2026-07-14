@props([
    'items' => [],
    'position' => 'bottom',
    'maxVisible' => 7,
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
    'overflow-x-auto scrollbar-hide',
    'max-w-[calc(100vw-2rem)]',
]) }}
    x-data="{ hovered: null }"
    style="scrollbar-width: none; -ms-overflow-style: none;">
    
    <div class="flex items-center gap-2 px-1">
        @foreach($items as $index => $item)
            <div class="relative flex-shrink-0 group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                              : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
