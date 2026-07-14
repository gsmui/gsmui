@props([
    'items' => [],
    'showStart' => true,
    'showTray' => true,
])

<div {{ $attributes->class([
    'flex items-center gap-1 z-50',
    'fixed bottom-0 left-0 right-0',
    'bg-zinc-900/95 dark:bg-zinc-100/95 backdrop-blur-xl',
    'px-2 py-1.5',
    'border-t border-zinc-700/50 dark:border-zinc-300/50',
]) }}>
    
    {{-- Start button --}}
    @if($showStart)
        <button class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-zinc-700 dark:hover:bg-zinc-200 transition-colors">
            <svg class="w-5 h-5 text-white dark:text-zinc-900" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 12V6.75l6-1.32v6.48L3 12zm17-9v8.75l-10 .15V5.21L20 3zM3 13l6 .09v6.81l-6-1.15V13zm17 .25V22l-10-1.91V13.1l10 .15z"/>
            </svg>
        </button>
    @endif
    
    {{-- Task items --}}
    @foreach($items as $index => $item)
        <div class="relative group">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-11 h-10 rounded-lg transition-all duration-150
                      {{ ($item['active'] ?? false) 
                          ? 'bg-zinc-700/50 dark:bg-zinc-300/50' 
                          : 'hover:bg-zinc-700/30 dark:hover:bg-zinc-300/30' }}">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
            
            {{-- Active indicator --}}
            @if($item['active'] ?? false)
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-blue-500 rounded-full"></div>
            @endif
        </div>
    @endforeach
    
    {{-- System tray --}}
    @if($showTray)
        <div class="ml-auto flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-zinc-700/30 dark:hover:bg-zinc-300/30 transition-colors">
            <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="text-xs text-zinc-400 dark:text-zinc-600">{{ now()->format('h:i A') }}</span>
        </div>
    @endif
</div>
