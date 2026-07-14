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
]) }}
    x-data="{ contextMenu: null, contextX: 0, contextY: 0 }">
    
    @foreach($items as $index => $item)
        <div class="relative"
             @contextmenu.prevent="contextMenu = {{ $index }}; contextX = $event.clientX; contextY = $event.clientY">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
    
    {{-- Context menu --}}
    <div x-show="contextMenu !== null" x-transition @click.outside="contextMenu = null"
         class="fixed z-50 w-48 bg-white dark:bg-zinc-800 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-700 p-1.5"
         :style="`left: ${contextX}px; top: ${contextY}px;`">
        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700">
            <span>📌</span> Pin to Dock
        </a>
        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700">
            <span>📋</span> Copy Link
        </a>
        <div class="h-px bg-zinc-200 dark:bg-zinc-700 my-1"></div>
        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
            <span>🗑️</span> Remove
        </a>
    </div>
</div>
