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
    x-data="{ openMenu: null, openSub: null }">
    
    @foreach($items as $index => $item)
        <div class="relative" 
             @mouseenter="openMenu = {{ $index }}" 
             @mouseleave="openMenu = null; openSub = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white' 
                          : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Submenu --}}
            @if(isset($item['submenu']))
                <div x-show="openMenu === {{ $index }}" x-transition
                     class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 bg-white dark:bg-zinc-800 rounded-xl shadow-xl border border-zinc-200 dark:border-zinc-700 p-1.5 min-w-[160px]">
                    @foreach($item['submenu'] as $sub)
                        <div class="relative" @mouseenter="openSub = '{{ $sub['label'] ?? '' }}'" @mouseleave="openSub = null">
                            <a href="{{ $sub['url'] ?? '#' }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                <span>{!! $sub['icon'] ?? '' !!}</span>
                                <span>{{ $sub['label'] ?? '' }}</span>
                                @if(isset($sub['submenu']))
                                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
