@props([
    'rough' => true,
    'inner' => true,
])

<div {{ $attributes->class([
    'p-4 rounded-lg',
    'bg-gradient-to-br from-stone-300 via-stone-400 to-stone-300',
    'border-4 border-stone-500',
    $rough ? 'shadow-[4px_4px_0_0_rgba(0,0,0,0.2)]' : 'shadow-lg',
]) }}>
    @if($inner)
    <div class="bg-white dark:bg-zinc-800 dark:bg-zinc-900 rounded overflow-hidden">
        {{ $slot }}
    </div>
    @else
    {{ $slot }}
    @endif
</div>
