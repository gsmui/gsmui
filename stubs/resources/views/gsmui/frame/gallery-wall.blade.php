@props([
    'shadow' => 'lg',
    'spacing' => '4',
])

<div {{ $attributes->class([
    'relative',
]) }}>
    {{-- Background shadow layer --}}
    <div class="absolute inset-0 bg-zinc-300 dark:bg-zinc-700 transform translate-x-2 translate-y-2 rounded-lg"></div>
    {{-- Frame --}}
    <div class="relative bg-white dark:bg-zinc-800 dark:bg-zinc-900 rounded-lg p-2 shadow-{{ $shadow }} border border-zinc-200 dark:border-zinc-700 dark:border-zinc-700">
        <div class="overflow-hidden rounded">
            {{ $slot }}
        </div>
    </div>
</div>
