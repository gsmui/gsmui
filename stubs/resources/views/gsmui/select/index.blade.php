@blaze(fold: true)

@props([
    'options' => [],
    'placeholder' => null,
    'size' => null,
    'invalid' => false,
    'disabled' => false,
    'name' => null,
    'label' => null,
    'class' => '',
])

@php
$sizeClasses = match ($size) {
    'sm' => 'h-8 text-sm',
    'xs' => 'h-6 text-xs',
    default => 'h-10 text-sm',
};

$classes = Gsmui::classes()
    ->add('block w-full rounded-lg border bg-white ps-3 pe-9 shadow-xs transition-colors')
    ->add('border-zinc-200 border-b-zinc-300/80 dark:border-white/10 dark:bg-white/10')
    ->add('disabled:cursor-not-allowed disabled:opacity-50')
    ->add($sizeClasses)
    ->add('data-invalid:border-red-500 dark:data-invalid:border-red-500')
    ->add($class)
    ;
@endphp

@if ($label)
    <label @if ($attributes->whereStartsWith('wire:model')->first()) for="{{ $attributes->whereStartsWith('wire:model')->first() }}" @endif class="mb-1 block text-sm font-medium text-zinc-800 dark:text-white">{{ $label }}</label>
@endif

<select
    @if ($name) name="{{ $name }}" @endif
    @disabled($disabled)
    @if ($invalid) data-invalid @endif
    {{ $attributes->class($classes) }}
>
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $value => $text)
        <option value="{{ $value }}">{{ $text }}</option>
    @endforeach

    {{ $slot }}
</select>
