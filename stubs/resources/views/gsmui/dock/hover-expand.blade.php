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
    'flex items-center gap-1.5 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center gap-2 rounded-xl transition-all duration-300 ease-[cubic-bezier(0.34,1.56,0.64,1)]
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white pl-3 pr-3 py-2.5' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 p-2.5' }}"
               :class="hovered === {{ $index }} ? 'pl-3 pr-3 py-2.5' : ''">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                <span class="text-sm font-medium whitespace-nowrap" 
                      x-show="hovered === {{ $index }}" 
                      x-transition:enter="transition ease-out duration-200"
                      x-transition:enter-start="opacity-0 w-0"
                      x-transition:enter-end="opacity-100 w-auto"
                      x-transition:leave="transition ease-in duration-150"
                      x-transition:leave-start="opacity-100 w-auto"
                      x-transition:leave-end="opacity-0 w-0"
                      style="overflow: hidden;">
                    {{ $item['label'] ?? '' }}
                </span>
            </a>
        </div>
    @endforeach
</div>
