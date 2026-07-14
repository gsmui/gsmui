@props([
    'items' => [],
    'position' => 'bottom',
    'tabs' => ['Home', 'Apps', 'Settings'],
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

<div {{ $attributes->class([
    'z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden',
]) }}
    x-data="{ activeTab: 0 }">
    
    {{-- Tab bar --}}
    <div class="flex border-b border-zinc-200 dark:border-zinc-700">
        @foreach($tabs as $index => $tab)
            <button @click="activeTab = {{ $index }}"
                    class="flex-1 px-4 py-2 text-xs font-medium transition-colors
                           {{ $index === 0 ? 'text-blue-600 border-b-2 border-blue-600' : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}"
                    :class="activeTab === {{ $index }} ? 'text-blue-600 border-b-2 border-blue-600' : 'text-zinc-500'">
                {{ $tab }}
            </button>
        @endforeach
    </div>
    
    {{-- Dock items --}}
    <div class="flex items-center gap-2 p-3">
        @foreach($items as $index => $item)
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-10 h-10 rounded-lg transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        @endforeach
    </div>
</div>
