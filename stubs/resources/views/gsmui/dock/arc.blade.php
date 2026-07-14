@props([
    'items' => [],
    'position' => 'bottom',
    'curve' => 'smile',
])

$positionClass = match($position) {
    'bottom' => 'fixed bottom-4 left-1/2 -translate-x-1/2',
    'top' => 'fixed top-4 left-1/2 -translate-x-1/2 -rotate-180',
    default => 'fixed bottom-4 left-1/2 -translate-x-1/2',
};

$itemCount = count($items);
@endphp

<div {{ $attributes->class([
    'flex items-end gap-0 z-50',
    $positionClass,
]) }}
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        @php
            $offset = abs($index - ($itemCount - 1) / 2);
            $maxOffset = ($itemCount - 1) / 2;
            $yOffset = $maxOffset > 0 ? ($offset / $maxOffset) * 20 : 0;
        @endphp
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null"
             style="margin-bottom: {{ $yOffset }}px;">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      bg-white dark:bg-zinc-800 shadow-lg border border-zinc-200 dark:border-zinc-700
                      {{ ($item['active'] ?? false) ? 'bg-blue-500 text-white border-blue-500' : 'text-zinc-500 dark:text-zinc-400' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-8px' : '0'})`">
                <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
