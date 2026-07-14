@props([
    'items' => [],
    'position' => 'bottom',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

$itemCount = count($items);
@endphp

<div {{ $attributes->class([
    'flex items-center gap-1 z-50',
    $positionClass,
    'bg-white dark:bg-zinc-800 rounded-2xl p-2 shadow-xl border border-zinc-200 dark:border-zinc-700',
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        @php
            $wave = sin(($index / $itemCount) * M_PI * 2) * 8;
        @endphp
        <div class="relative group transition-all duration-300" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null"
             style="transform: translateY({{ $wave }}px);">
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
