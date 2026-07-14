@blaze(fold: true)

@props([
    'gap' => null,
    'justify' => 'center',
    'label' => null,
])

@php
$gapClass = match ($gap) {
    'sm' => 'gap-0.5',
    'lg' => 'gap-1.5',
    'xl' => 'gap-2',
    default => 'gap-1',
};

$justifyClass = match ($justify) {
    'start' => 'justify-start',
    'end' => 'justify-end',
    'between' => 'justify-between',
    'around' => 'justify-around',
    default => 'justify-center',
};
@endphp

<div {{ $attributes->class('flex w-full items-center ' . $gapClass . ' ' . $justifyClass) }} data-gsmui-kbd-row>
    @if ($label)
        <span class="text-[10px] font-medium text-zinc-400 dark:text-zinc-500 uppercase tracking-wider shrink-0 w-8 text-right mr-2">{{ $label }}</span>
    @endif
    {{ $slot }}
</div>
