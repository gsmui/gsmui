@blaze(fold: true, unsafe: [
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props([
    'placeholder' => null,
    'rows' => 4,
    'resize' => 'vertical',
    'invalid' => false,
    'disabled' => false,
    'name' => null,
])

@php
$name ??= $attributes->whereStartsWith('wire:model')->first();

$invalid = $invalid ?: ($name && $errors->has($name));

$isAutoRows = $rows === 'auto' || $rows === 'auto';

$classes = Gsmui::classes()
    ->add('block w-full rounded-lg px-3 py-2')
    ->add('text-base sm:text-sm')
    ->add('shadow-xs disabled:shadow-none')
    ->add('bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]')
    ->add('text-zinc-700 dark:text-zinc-300 disabled:text-zinc-500 dark:disabled:text-zinc-400')
    ->add('placeholder-zinc-400 dark:placeholder-zinc-400')
    ->add(match ($resize) {
        'none' => 'resize-none',
        'horizontal' => 'resize-x',
        'both' => 'resize',
        default => 'resize-y',
    })
    ->add($invalid
        ? 'border border-red-500'
        : 'border border-zinc-200 border-b-zinc-300/80 dark:border-white/10'
    )
    ->add('outline-none focus:ring-0 focus:ring-offset-0')
    ;

if ($isAutoRows) {
    $classes = $classes->add('field-sizing-content min-h-[5rem]');
}
@endphp

<gsmui:with-field :$attributes :$name>
    <textarea
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if (! $isAutoRows) rows="{{ $rows }}" @endif
        @if ($disabled) disabled @endif
        @if ($invalid) aria-invalid="true" data-invalid @endif
        {{ $attributes->except(['placeholder', 'rows', 'resize', 'disabled'])->class($classes) }}
        data-gsmui-textarea
    >{{ $slot }}</textarea>
</gsmui:with-field>
