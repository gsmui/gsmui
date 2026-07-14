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
    'relative flex items-center gap-2 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2',
]) }}
    x-data="{ hovered: null }">
    
    {{-- Shadow layers --}}
    <div class="absolute inset-0 rounded-2xl bg-zinc-200 dark:bg-zinc-700 translate-y-1 translate-x-0.5 opacity-50"></div>
    <div class="absolute inset-0 rounded-2xl bg-zinc-300 dark:bg-zinc-600 translate-y-0.5 opacity-30"></div>
    
    <div class="relative flex items-center gap-2">
        @foreach($items as $index => $item)
            <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200 relative z-10
                          {{ ($item['active'] ?? false) 
                              ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 shadow-xl' 
                              : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-600 shadow-lg' }}"
                   :style="`transform: translateY(${hovered === {{ $index }} ? '-8px' : '0'})`">
                    <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
