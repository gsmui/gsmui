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
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
    'transition-all duration-300',
]) }}
    x-data="{ expanded: false }"
    @mouseenter="expanded = true" @mouseleave="expanded = false">
    
    @foreach($items as $index => $item)
        <div class="relative">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center gap-2 rounded-xl transition-all duration-300 overflow-hidden
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white pl-2.5 pr-2.5' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
               :class="expanded ? 'px-3 py-2.5' : 'p-2.5 justify-center'"
               :style="`transition-delay: ${expanded ? '{{ $index * 30 }}ms' : '0ms'}`">
                <span class="text-lg flex-shrink-0">{!! $item['icon'] ?? '🏠' !!}</span>
                <span x-show="expanded" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                      class="text-sm font-medium whitespace-nowrap">{{ $item['label'] ?? '' }}</span>
            </a>
        </div>
    @endforeach
</div>
