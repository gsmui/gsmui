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
    'bg-zinc-950 rounded-xl p-2',
    'border border-zinc-800',
    'shadow-[0_0_30px_rgba(0,0,0,0.5)]',
    'font-mono',
]) }}
    x-data="{ hovered: null }">
    
    {{-- Terminal dots --}}
    <div class="flex gap-1.5 px-2 mr-2">
        <div class="w-3 h-3 rounded-full bg-red-500"></div>
        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
        <div class="w-3 h-3 rounded-full bg-green-500"></div>
    </div>
    
    @foreach($items as $index => $item)
        <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-10 h-10 rounded-lg transition-all duration-200
                      {{ ($item['active'] ?? false) 
                          ? 'bg-green-500/20 text-green-400 border border-green-500/30' 
                          : 'text-zinc-500 hover:bg-zinc-800 hover:text-green-400' }}"
               :class="hovered === {{ $index }} ? 'border border-zinc-700' : 'border border-transparent'">
                <span class="text-base">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
    
    {{-- Cursor blink --}}
    <div class="w-2 h-5 bg-green-500 ml-2 animate-pulse"></div>
</div>
