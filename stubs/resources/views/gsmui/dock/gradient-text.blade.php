@props([
    'items' => [],
    'position' => 'bottom',
    'showLabels' => true,
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center gap-2 z-50',
    $positionClass,
    'bg-zinc-900 dark:bg-zinc-100 rounded-2xl p-2 shadow-2xl',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) ? 'bg-zinc-800 dark:bg-zinc-200' : 'hover:bg-zinc-800/50 dark:hover:bg-zinc-200/50' }}">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                @if($showLabels)
                    <span class="text-[10px] font-semibold bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                        {{ $item['label'] ?? '' }}
                    </span>
                @endif
            </a>
        </div>
    @endforeach
</div>
