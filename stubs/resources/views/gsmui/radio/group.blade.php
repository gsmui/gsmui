@blaze(fold: true, unsafe: [
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props([
    'label' => null,
    'description' => null,
    'variant' => 'default',
    'invalid' => false,
    'disabled' => false,
    'name' => null,
])

@php
$name ??= $attributes->whereStartsWith('wire:model')->first();

$isCards = $variant === 'cards';
$isSegmented = $variant === 'segmented';
$isPills = $variant === 'pills';
$isButtons = $variant === 'buttons';

$groupClasses = Gsmui::classes()
    ->add('flex flex-wrap')
    ->add($isCards ? 'gap-3 flex-col' : ($isSegmented ? 'inline-flex rounded-lg bg-zinc-100 dark:bg-zinc-800 p-0.5 gap-0' : ($isPills ? 'gap-2 items-center' : ($isButtons ? 'gap-0 inline-flex' : 'gap-4 items-center'))))
    ;
@endphp

<gsmui:with-field :$attributes :$name>
    <div {{ $attributes->except(['wire:model', 'label', 'description', 'variant'])->class($groupClasses) }} data-gsmui-radio-group role="radiogroup">
        {{ $slot }}
    </div>
</gsmui:with-field>
