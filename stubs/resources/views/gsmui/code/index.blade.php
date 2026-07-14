@blaze(fold: true)

@props([
    'variant' => 'terminal',
    'size' => null,
])

@php
$classes = Gsmui::classes()
    ->add('relative w-full overflow-hidden rounded-xl font-mono text-sm leading-relaxed select-none')
    ->add(match ($size) {
        'sm' => 'text-xs max-w-lg',
        'lg' => 'text-base max-w-5xl',
        'xl' => 'text-lg max-w-7xl',
        default => 'text-sm max-w-3xl',
    })
    ->add(match ($variant) {
        'light' => 'bg-zinc-50 border border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700',
        'editor' => 'bg-zinc-950 border border-zinc-800 shadow-xl',
        default => 'bg-zinc-900 border border-zinc-700 shadow-xl',
    })
    ->add(match ($variant) {
        'light' => 'text-zinc-800 dark:text-zinc-200',
        default => 'text-zinc-100',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-code>
    <div class="p-4 overflow-x-auto">
        {{ $slot }}
    </div>
</div>
