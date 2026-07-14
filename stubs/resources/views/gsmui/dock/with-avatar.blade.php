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
               class="flex items-center justify-center w-12 h-12 rounded-xl transition-all duration-200
                      {{ ($item['active'] ?? false) ? 'ring-2 ring-blue-500 ring-offset-2 ring-offset-white dark:ring-offset-zinc-800' : '' }}"
               :style="`transform: scale(${hovered === {{ $index }} ? 1.1 : 1})`">
                @if(isset($item['avatar']))
                    <img src="{{ $item['avatar'] }}" alt="{{ $item['label'] ?? '' }}" class="w-full h-full rounded-xl object-cover" />
                @else
                    <div class="w-full h-full rounded-xl bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($item['label'] ?? '?', 0, 1)) }}
                    </div>
                @endif
            </a>
            
            @if($item['online'] ?? false)
                <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white dark:border-zinc-800"></div>
            @endif
        </div>
    @endforeach
</div>
