@props([
    'border' => true,
    'shadow' => true,
    'ornament' => true,
])

<div {{ $attributes->class([
    'relative rounded-xl overflow-hidden',
    $border ? 'border border-zinc-200 dark:border-zinc-700 dark:border-zinc-700' : '',
    $shadow ? 'shadow-xl' : '',
]) }}>
    @if($ornament)
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
    @endif
    {{ $slot }}
</div>
