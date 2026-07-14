@props([
    'bolt' => true,
    'rivets' => false,
])

<div {{ $attributes->class([
    'relative bg-zinc-200 dark:bg-zinc-800 rounded-lg border-2 border-zinc-400 dark:border-zinc-600',
    'shadow-inner',
]) }}>
    @if($bolt)
    <div class="absolute top-2 left-2 w-3 h-3 bg-zinc-400 dark:bg-zinc-500 rounded-full shadow-inner"></div>
    <div class="absolute top-2 right-2 w-3 h-3 bg-zinc-400 dark:bg-zinc-500 rounded-full shadow-inner"></div>
    <div class="absolute bottom-2 left-2 w-3 h-3 bg-zinc-400 dark:bg-zinc-500 rounded-full shadow-inner"></div>
    <div class="absolute bottom-2 right-2 w-3 h-3 bg-zinc-400 dark:bg-zinc-500 rounded-full shadow-inner"></div>
    @endif
    {{ $slot }}
</div>
