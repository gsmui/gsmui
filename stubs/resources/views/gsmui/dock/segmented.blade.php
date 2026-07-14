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
    'flex items-center gap-1.5 z-50',
    $positionClass,
    'bg-zinc-900 dark:bg-zinc-100 rounded-2xl p-2 shadow-xl',
]) }}
    x-data="{ hovered: null, activeSegment: 0 }">
    
    @foreach($items as $index => $item)
        @if(($item['type'] ?? '') === 'segment-start')
            <div class="flex items-center gap-0.5 bg-zinc-800 dark:bg-zinc-200 rounded-xl p-1">
        @elseif(($item['type'] ?? '') === 'segment-end')
            </div>
        @else
            <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-10 h-10 rounded-lg transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-zinc-700 dark:bg-zinc-300 text-white dark:text-zinc-900' 
                              : 'text-zinc-400 dark:text-zinc-600 hover:bg-zinc-700/50 dark:hover:bg-zinc-300/50' }}">
                    <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endif
    @endforeach
</div>
