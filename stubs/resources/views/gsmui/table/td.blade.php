@blaze(fold: true)

@props([
    'align' => 'left',
    'colspan' => null,
    'width' => null,
])

@php
$classes = Gsmui::classes()
    ->add('text-zinc-700 dark:text-zinc-300')
    ->add(match ($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    })
    ;
@endphp

<td {{ $attributes->class($classes) }} @if ($colspan) colspan="{{ $colspan }}" @endif @if ($width) style="width: {{ $width }}" @endif data-gsmui-table-td>
    {{ $slot }}
</td>
