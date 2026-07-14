@blaze(fold: true)

@props([
    'variant' => 'default',
])

@php
$classes = Gsmui::classes()
    ->add('flex flex-col gap-1')
    ->add('p-2')
    ->add('bg-white dark:bg-zinc-800')
    ->add('border border-zinc-200 dark:border-white/10')
    ->add('rounded-xl')
    ->add('w-full max-w-xs')
    ;
@endphp

<nav
    {{ $attributes->class($classes) }}
    data-gsmui-navmenu
    aria-label="{{ __('Navigation') }}"
>
    {{ $slot }}
</nav>
