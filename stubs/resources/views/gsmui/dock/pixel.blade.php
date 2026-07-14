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
    'bg-zinc-900 rounded-lg p-2 shadow-2xl',
    'border-4 border-zinc-700',
    'image-rendering: pixelated',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-11 h-11 transition-all duration-100
                      {{ ($item['active'] ?? false) 
                          ? 'bg-green-500 text-zinc-900 border-2 border-green-300' 
                          : 'text-green-400 hover:bg-zinc-800 border-2 border-transparent hover:border-green-600' }}">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
