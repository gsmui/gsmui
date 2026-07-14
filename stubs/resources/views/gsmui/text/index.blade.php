@blaze(fold: true)

@props([
    'variant' => null,
    'color' => null,
    'inline' => false,
    'size' => null,
])

@php
$classes = Gsmui::classes()
    ->add(match ($variant) {
        'strong' => 'font-medium text-zinc-900 dark:text-white',
        'subtle' => 'text-zinc-400 dark:text-zinc-500',
        default => 'text-zinc-600 dark:text-zinc-400',
    })
    ->add(match ($size) {
        'sm' => 'text-sm',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        default => 'text-base',
    })
    ->add($color ? "text-{$color}-600 dark:text-{$color}-400" : '')
    ;

$tag = $inline ? 'span' : 'p';
@endphp

<{{ $tag }} {{ $attributes->class($classes) }} data-gsmui-text>
    {{ $slot }}
</{{ $tag }}>
