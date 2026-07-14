@props([
    'caption' => '',
    'rotation' => 0,
    'shadow' => true,
])

<div {{ $attributes->class([
    'bg-white dark:bg-zinc-800 p-3 pb-12 inline-block',
    $shadow ? 'shadow-xl' : '',
]) }} style="transform: rotate({{ $rotation }}deg);">
    <div class="bg-zinc-100 dark:bg-zinc-800 aspect-square overflow-hidden">
        {{ $slot }}
    </div>
    @if($caption)
    <p class="absolute bottom-3 left-0 right-0 text-center text-sm font-handwriting text-zinc-700 dark:text-zinc-300">
        {{ $caption }}
    </p>
    @endif
</div>
