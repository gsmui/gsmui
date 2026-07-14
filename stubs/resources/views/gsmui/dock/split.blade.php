@props([
    'items' => [],
    'secondaryItems' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'flex items-center gap-3 z-50',
    $positionClass,
]) }}
    x-data="{ hovered: null }">
    
    {{-- Primary dock --}}
    <div class="flex items-center gap-1.5 bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700">
        @foreach($items as $index => $item)
            <div class="relative group" @mouseenter="hovered = 'p-{{ $index }}'" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-11 h-11 rounded-xl transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                              : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endforeach
    </div>
    
    {{-- Secondary dock --}}
    @if(count($secondaryItems) > 0)
        <div class="flex items-center gap-1.5 bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700">
            @foreach($secondaryItems as $index => $item)
                <div class="relative group" @mouseenter="hovered = 's-{{ $index }}'" @mouseleave="hovered = null">
                    <a href="{{ $item['url'] ?? '#' }}"
                       class="flex items-center justify-center w-10 h-10 rounded-xl transition-all duration-200
                              {{ ($item['active'] ?? false) 
                                  ? 'bg-blue-500 text-white' 
                                  : 'text-zinc-400 dark:text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                        <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
