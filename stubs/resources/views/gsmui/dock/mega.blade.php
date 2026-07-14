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
]) }}
    x-data="{ activeItem: null }">
    
    {{-- Preview panel --}}
    <div x-show="activeItem !== null" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="absolute bottom-full left-1/2 -translate-x-1/2 mb-4 bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 p-4 min-w-[200px]">
        <template x-if="activeItem !== null">
            <div>
                <div class="text-lg font-semibold text-zinc-900 dark:text-white" x-text="activeItem?.label"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1" x-text="activeItem?.description"></div>
            </div>
        </template>
    </div>
    
    {{-- Dock --}}
    <div class="flex items-center gap-2 bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700">
        @foreach($items as $index => $item)
            <div class="relative"
                 @mouseenter="activeItem = { label: '{{ $item['label'] ?? '' }}', description: '{{ $item['description'] ?? '' }}' }"
                 @mouseleave="activeItem = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                              : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                    <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
