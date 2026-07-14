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
    'flex items-center gap-0 z-50',
    $positionClass,
]) }}
    x-data="{ hovered: null }">
    
    {{-- Left section --}}
    <div class="flex items-center gap-1 bg-zinc-900 rounded-l-2xl p-2 pr-1">
        @foreach(array_slice($items, 0, ceil(count($items) / 2)) as $index => $item)
            <div class="relative" @mouseenter="hovered = {{ $index }}" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-11 h-11 rounded-xl transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-white/20 text-white' 
                              : 'text-zinc-400 hover:bg-white/10 hover:text-white' }}">
                    <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endforeach
    </div>
    
    {{-- Divider --}}
    <div class="w-px h-10 bg-zinc-700"></div>
    
    {{-- Right section --}}
    <div class="flex items-center gap-1 bg-zinc-800 rounded-r-2xl p-2 pl-1">
        @foreach(array_slice($items, ceil(count($items) / 2)) as $index => $item)
            @php $offsetIndex = $index + ceil(count($items) / 2); @endphp
            <div class="relative" @mouseenter="hovered = {{ $offsetIndex }}" @mouseleave="hovered = null">
                <a href="{{ $item['url'] ?? '#' }}"
                   class="flex items-center justify-center w-11 h-11 rounded-xl transition-all duration-200
                          {{ ($item['active'] ?? false) 
                              ? 'bg-blue-500 text-white' 
                              : 'text-zinc-500 hover:bg-zinc-700 hover:text-white' }}">
                    <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
