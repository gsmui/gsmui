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
    'flex items-end gap-0.5 z-50',
    $positionClass,
    'bg-zinc-200 dark:bg-zinc-700 rounded-t-2xl p-1.5 pb-0',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center gap-2 px-3 py-2 rounded-t-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white' 
                          : 'bg-zinc-300/50 dark:bg-zinc-600/50 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-300 dark:hover:bg-zinc-600' }}">
                <span class="text-sm">{!! $item['icon'] ?? '🏠' !!}</span>
                <span class="text-xs font-medium hidden sm:inline">{{ $item['label'] ?? '' }}</span>
            </a>
        </div>
    @endforeach
</div>
