@blaze

@props([
    'selectedSuffix' => null,
    'placeholder' => null,
    'searchable' => null,
    'clearable' => null,
    'invalid' => null,
    'trigger' => null,
    'empty' => null,
    'clear' => null,
    'close' => null,
    'name' => null,
    'size' => null,
    'input' => null,
])

@php
// We only want to show the name attribute on the checkbox if it has been set
// manually, but not if it has been set from the wire:model attribute...
$showName = isset($name);

if (! isset($name)) {
    $name = $attributes->whereStartsWith('wire:model')->first();
}

if ($searchable) {
    throw new \Exception('Comboboxes do not support the searchable prop.');
}

$invalid ??= ($name && $errors->has($name));

$class = Gsmui::classes()
    ->add('w-full')
    // The below reverts styles added by Tailwind Forms plugin
    ->add('border-0 p-0 bg-transparent')
    ;
@endphp

<ui-pillbox
    clear="{{ $clear ?? 'close esc select' }}"
    @if ($close) close="{{ $close }}" @endif
    {{ $attributes->class($class)->merge(['filter' => true]) }}
    @if($showName) name="{{ $name }}" @endif
    data-gsmui-control
    data-gsmui-pillbox
>
    <?php if ($trigger): ?> {{ $trigger }} <?php else: ?>
        <gsmui:pillbox.trigger class="cursor-text" :$placeholder :$invalid :$size :$clearable :suffix="$selectedSuffix">
            <gsmui:pillbox.selected :$size :suffix="$selectedSuffix">
                <x-slot name="input">
                    <?php if ($input): ?> {{ $input }} <?php else: ?>
                        <gsmui:pillbox.input :$placeholder />
                    <?php endif; ?>
                </x-slot>
            </gsmui:pillbox.selected>
        </gsmui:pillbox.trigger>
    <?php endif; ?>

    <gsmui:pillbox.options>
        <?php if ($empty): ?>
            <?php if (is_string($empty)): ?>
                <gsmui:pillbox.option.empty>{!! __($empty) !!}</gsmui:pillbox.option.empty>
            <?php else: ?>
                {{ $empty }}
            <?php endif; ?>
        <?php else: ?>
            <gsmui:pillbox.option.empty when-loading="{!! __('Loading...') !!}">
                {!! __('No results found') !!}
            </gsmui:pillbox.option.empty>
        <?php endif; ?>

        {{ $slot }}
    </gsmui:pillbox.options>
</ui-pillbox>