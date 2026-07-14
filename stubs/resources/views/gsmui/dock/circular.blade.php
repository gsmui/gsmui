@props([
    'items' => [],
    'size' => 'md',
])

@php
$sizes = [
    'sm' => ['container' => 'w-48 h-48', 'radius' => 70, 'item' => 'w-10 h-10'],
    'md' => ['container' => 'w-64 h-64', 'radius' => 100, 'item' => 'w-12 h-12'],
    'lg' => ['container' => 'w-80 h-80', 'radius' => 130, 'item' => 'w-14 h-14'],
];
$sizeSet = $sizes[$size] ?? $sizes['md'];
$itemCount = count($items);
@endphp

<div {{ $attributes->class([
    'relative z-50',
    $sizeSet['container'],
    'flex items-center justify-center',
]) }}>
    {{-- Center hub --}}
    <div class="absolute w-16 h-16 bg-zinc-900 dark:bg-white rounded-full flex items-center justify-center text-white dark:text-zinc-900 shadow-xl z-10">
        <span class="text-xl">☰</span>
    </div>
    
    @foreach($items as $index => $item)
        @php
            $angle = ($index / $itemCount) * 360 - 90;
            $rad = $angle * M_PI / 180;
            $x = $sizeSet['radius'] * cos($rad);
            $y = $sizeSet['radius'] * sin($rad);
        @endphp
        <div class="absolute {{ $sizeSet['item'] }} transition-all duration-300 hover:scale-110"
             style="left: calc(50% + {{ $x }}px - 24px); top: calc(50% + {{ $y }}px - 24px);">
            <a href="{{ $item['url'] ?? '#' }}"
               class="flex items-center justify-center w-full h-full rounded-full
                      {{ ($item['active'] ?? false) 
                          ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' 
                          : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 shadow-lg hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">
                <span class="text-lg">{!! $item['icon'] ?? '🏠' !!}</span>
            </a>
        </div>
    @endforeach
</div>
