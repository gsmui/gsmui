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
    'bg-amber-800 rounded-2xl p-2 shadow-xl',
    'bg-[length:20px_20px]',
    'bg-[repeating-linear-gradient(90deg,transparent,transparent_10px,rgba(0,0,0,0.05)_10px,rgba(0,0,0,0.05)_11px)]',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-amber-900/50 text-amber-100' 
                          : 'text-amber-200/70 hover:bg-amber-900/30 hover:text-amber-100' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-2px' : '0'})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
