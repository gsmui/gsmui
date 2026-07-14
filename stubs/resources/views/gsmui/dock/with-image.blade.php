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
    x-data="{ hovered: null }">
    
    @foreach($items as $index => $item)
        <div class="relative group" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="block w-14 h-14 rounded-xl overflow-hidden transition-all duration-200
                      {{ ($item['active'] ?? false) ? 'ring-2 ring-blue-500' : '' }}"
               :style="`transform: translateY(${hovered === {{ $index }} ? '-6px' : '0'}) scale(${hovered === {{ $index }} ? 1.08 : 1})`">
                @if(isset($item['image']))
                    <img src="{{ $item['image'] }}" alt="{{ $item['label'] ?? '' }}" class="w-full h-full object-cover" />
                @else
                    <div class="w-full h-full bg-gradient-to-br {{ $item['gradient'] ?? 'from-zinc-100 to-zinc-200 dark:from-zinc-700 dark:to-zinc-600' }} flex items-center justify-center">
                        <span class="text-xl">{!! $item['icon'] ?? '🏠' !!}</span>
                    </div>
                @endif
            </a>
        </div>
    @endforeach
</div>
