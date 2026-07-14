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
    'bg-gradient-to-r from-violet-500/20 to-fuchsia-500/20 backdrop-blur-2xl',
    'rounded-[30px] p-2.5',
    'border border-white/20 dark:border-white/10',
    'shadow-[0_8px_32px_rgba(139,92,246,0.2)]',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-[20px] transition-all duration-500
                      {{ ($item['active'] ?? false) 
                          ? 'bg-gradient-to-br from-violet-500 to-fuchsia-500 text-white shadow-lg' 
                          : 'text-white/70 hover:bg-white/10' }}"
               :style="`border-radius: ${hovered === {{ $index }} ? '50%' : '20px'};`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
