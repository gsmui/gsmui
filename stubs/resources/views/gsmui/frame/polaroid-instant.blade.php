@props([
    'caption' => '',
    'rotation' => 0,
    'shadow' => true,
])

<div {{ $attributes->class([
    'inline-block bg-white dark:bg-zinc-800',
    'shadow-lg',
    'rotate-[' . $rotation . 'deg]',
]) }} style="padding: 12px 12px 48px 12px;">
    <div class="bg-zinc-100 dark:bg-zinc-800 aspect-square overflow-hidden relative">
        {{ $slot }}
        {{-- Viewfinder overlay --}}
        <div class="absolute inset-0 border-2 border-white/30 pointer-events-none"></div>
    </div>
    @if($caption)
    <p class="absolute bottom-3 left-0 right-0 text-center text-sm font-handwriting text-zinc-700 dark:text-zinc-300">
        {{ $caption }}
    </p>
    @endif
</div>
