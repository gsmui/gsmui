@blaze(fold: true)

@props([
    'color' => null,
    'end' => false,
])

@php
$classes = Gsmui::classes()
    ->add('relative px-3.5 py-2 text-sm leading-relaxed')
    ->add($end ? 'rounded-2xl rounded-br-sm' : 'rounded-2xl rounded-bl-sm')
    ->add(match ($color) {
        'primary' => 'bg-blue-600 text-white',
        'secondary' => 'bg-violet-600 text-white',
        'accent' => 'bg-amber-500 text-white',
        'neutral' => 'bg-zinc-700 text-white dark:bg-zinc-600',
        'info' => 'bg-sky-100 text-sky-900 dark:bg-sky-900/40 dark:text-sky-200',
        'success' => 'bg-emerald-100 text-emerald-900 dark:bg-emerald-900/40 dark:text-emerald-200',
        'warning' => 'bg-amber-100 text-amber-900 dark:bg-amber-900/40 dark:text-amber-200',
        'danger' => 'bg-red-100 text-red-900 dark:bg-red-900/40 dark:text-red-200',
        default => 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100',
    })
    ->add('break-words')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-chat-bubble>
    {{ $slot }}
</div>
