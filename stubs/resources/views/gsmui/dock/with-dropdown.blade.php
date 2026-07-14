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
    x-data="{ open: null }">
    
    @foreach($items as $index => $item)
        <div class="relative"
             @if(isset($item['children']))
                 @click="open = open === {{ $index }} ? null : {{ $index }}"
                 @click.outside="open = null"
             @endif>
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Dropdown menu --}}
            @if(isset($item['children']))
                <div x-show="open === {{ $index }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 -translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 bg-white dark:bg-zinc-800 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-700 p-1.5">
                    @foreach($item['children'] as $child)
                        <a href="{{ $child['url'] ?? '#' }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                            <span>{!! $child['icon'] ?? '' !!}</span>
                            <span>{{ $child['label'] ?? '' }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
