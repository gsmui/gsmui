@blaze(fold: true)

@props([
    'badge' => null,
])

@php
$classes = Gsmui::classes()
    ->add('block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5')
    ;
@endphp

<label {{ $attributes->class($classes) }} data-gsmui-label>
    {{ $slot }}
    @if ($badge)
        <span class="ml-2 rounded bg-zinc-100 dark:bg-white/10 px-1.5 py-0.5 text-xs text-zinc-500 dark:text-zinc-400">{{ $badge }}</span>
    @endif
</label>
