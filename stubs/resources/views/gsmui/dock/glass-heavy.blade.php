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
    'bg-white/10 dark:bg-white/5 backdrop-blur-[40px]',
    'rounded-2xl p-2.5',
    'shadow-[inset_0_1px_1px_rgba(255,255,255,0.3)]',
    'border border-white/20 dark:border-white/10',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300
                      {{ ($item['active'] ?? false) 
                          ? 'bg-white/25 shadow-[inset_0_1px_0_rgba(255,255,255,0.3)]' 
                          : 'hover:bg-white/15' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-4px' : '0'}) scale(${hovered === {{ $index }} ? 1.05 : 1})`">
                <span class="text-xl text-white dark:text-white">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
