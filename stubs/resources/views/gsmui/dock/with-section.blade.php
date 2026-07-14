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
    'flex items-center gap-1 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        @if(($item['type'] ?? '') === 'section')
            <div class="flex flex-col items-center px-1">
                <span class="text-[9px] font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider">{{ $item['label'] ?? '' }}</span>
            </div>
        @elseif(($item['type'] ?? '') === 'separator')
            <div class="w-px h-8 bg-zinc-200 dark:bg-zinc-600 mx-0.5"></div>
        @else
            <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-10 h-10 rounded-lg transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                              : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endif
    @endforeach
</div>
