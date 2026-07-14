@blaze(fold: true)

@props([
    'size' => null,
    'level' => null,
    'accent' => false,
])

@php
$classes = Gsmui::classes()
    ->add(match ($size) {
        'xl' => 'text-2xl font-bold tracking-tight',
        'lg' => 'text-lg font-semibold',
        default => 'text-base font-semibold',
    })
    ->add('text-zinc-900 dark:text-white')
    ->add($accent ? 'text-accent' : '')
    ;

$tag = match ((int) $level) {
    1 => 'h1',
    2 => 'h2',
    3 => 'h3',
    4 => 'h4',
    default => 'div',
};
@endphp

<{{ $tag }} {{ $attributes->class($classes) }} data-gsmui-heading>
    {{ $slot }}
</{{ $tag }}>
