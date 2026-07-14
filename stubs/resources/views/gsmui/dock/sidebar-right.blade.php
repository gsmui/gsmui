@props([
    'items' => [],
    'collapsed' => false,
])

<div {{ $attributes->class([
    'flex flex-col items-center gap-2 z-50',
    'fixed right-4 top-1/2 -translate-y-1/2',
    $collapsed ? 'w-16' : 'w-16',
    'bg-white dark:bg-zinc-800 rounded-2xl py-3 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-10 h-10 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Tooltip --}}
            <div class="absolute right-full mr-3 top-1/2 -translate-y-1/2 px-2.5 py-1 bg-zinc-900 dark:bg-zinc-700 text-white text-xs rounded-lg
                        opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50 shadow-lg">
                {{ $item['label'] ?? '' }}
            </div>
        </div>
    @endforeach
</div>
