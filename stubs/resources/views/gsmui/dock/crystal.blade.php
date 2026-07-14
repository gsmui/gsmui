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
    'bg-gradient-to-br from-white/30 to-white/10 dark:from-white/10 dark:to-white/5',
    'backdrop-blur-xl',
    'rounded-2xl p-2',
    'shadow-[0_0_20px_rgba(255,255,255,0.1)]',
    'border border-white/40 dark:border-white/20',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-300
                      bg-gradient-to-br from-white/20 to-white/5 dark:from-white/10 dark:to-white/5
                      {{ ($item['active'] ?? false) 
                          ? 'ring-1 ring-white/30 shadow-[inset_0_1px_0_rgba(255,255,255,0.3)]' 
                          : 'hover:from-white/30 hover:to-white/10' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.1 : 1})`">
                <span class="text-xl text-white/90">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
