@props([
    'items' => [],
    'header' => 'Navigation',
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex flex-col items-center gap-2 z-50',
    $positionClass,
]) }}
    x-data="{ hovered: null }">
    
    {{-- Header --}}
    <div class="px-3 py-1 bg-zinc-900 dark:bg-zinc-700 text-white text-[10px] font-medium rounded-full">
        {{ $header }}
    </div>
    
    {{-- Dock --}}
    <div class="flex items-center gap-1.5 bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700">
        @foreach($items as $index => $item)
            <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-11 h-11 rounded-xl transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-blue-500 text-white' 
                              : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
