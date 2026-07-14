@props([
    'items' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    'left' => 'fixed left-4 top-1/2 -translate-y-1/2 flex-col',
    'right' => 'fixed right-4 top-1/2 -translate-y-1/2 flex-col',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center gap-0.5 z-50',
    $positionClass,
    'bg-zinc-100 dark:bg-zinc-800 rounded-xl p-1 shadow-lg border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-8 h-8 rounded-lg transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-200 dark:bg-zinc-600 text-zinc-900 dark:text-white' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.2 : 1})`">
                <span class="text-sm">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
