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
    'bg-white/40 dark:bg-zinc-800/40 backdrop-blur-[20px]',
    'rounded-2xl p-2',
    'shadow-[0_8px_32px_0_rgba(31,38,135,0.2)]',
    'border border-white/30 dark:border-white/10',
    'ring-1 ring-inset ring-white/20 dark:ring-white/5',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-11 h-11 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white/30 dark:bg-white/15 shadow-inner' 
                          : 'hover:bg-white/20 dark:hover:bg-white/10' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-4px' : '0'}) scale(${hovered === {{ $index }} ? 1.05 : 1})`">
                <span class="text-lg text-zinc-700 dark:text-zinc-200">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
