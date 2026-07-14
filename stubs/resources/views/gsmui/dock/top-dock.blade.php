@props([
    'items' => [],
    'fullWidth' => false,
])

<div {{ $attributes->class([
    'flex items-center gap-2 z-50',
    $fullWidth ? 'fixed top-0 left-0 right-0 justify-center' : 'fixed top-4 left-1/2 -translate-x-1/2',
    'bg-white dark:bg-zinc-800 rounded-2xl px-4 py-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center gap-2 px-3 py-2 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                <span class="text-sm font-medium">{{ $item['label'] ?? '' }}</span>
            </a>
        </div>
    @endforeach
</div>
