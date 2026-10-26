@blaze(fold: true, unsafe: [
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props([
    'placeholder' => null,
    'type' => 'text',
    'size' => null,
    'variant' => 'outline',
    'invalid' => false,
    'disabled' => false,
    'readonly' => false,
    'multiple' => false,
    'icon' => null,
    'iconTrailing' => null,
    'clearable' => false,
    'copyable' => false,
    'viewable' => false,
    'kbd' => null,
    'as' => 'input',
    'inputClass' => null,
    'name' => null,
])

@php
$name ??= $attributes->whereStartsWith('wire:model')->first();

$invalid = $invalid ?: ($name && $errors->has($name));

$isButton = $as === 'button';
$isFile = $type === 'file';

$classes = Gsmui::classes()
    ->add('w-full flex items-center overflow-hidden')
    ->add('shadow-xs disabled:shadow-none')
    ->add('bg-white dark:bg-white/10 dark:disabled:bg-white/[7%]')
    ->add(match ($size) {
        'sm' => 'h-8 text-sm rounded-md px-3',
        'xs' => 'h-6 text-xs rounded-md px-3',
        default => 'h-10 text-base sm:text-sm rounded-lg px-3',
    })
    ->add($invalid
        ? 'border border-red-500'
        : 'border border-zinc-200 border-b-zinc-300/80 dark:border-white/10'
    )
    ->add($variant === 'filled' ? 'bg-zinc-800/5 dark:bg-white/10' : '')
    ;

$inputClasses = Gsmui::classes()
    ->add('block w-full min-w-0')
    ->add('border-0 bg-transparent p-0')
    ->add('[font-size:inherit] [line-height:inherit]')
    ->add('focus:ring-0 focus:ring-offset-0 focus:outline-none')
    ->add('disabled:text-zinc-500 dark:disabled:text-zinc-400')
    ->add('placeholder-zinc-400 dark:placeholder-zinc-400')
    ->add($inputClass ?: $attributes->get('input:class'))
    ;

$isPassword = $type === 'password';

// `??` binds looser than `||`, so `$icon || $slot->icon ?? ...` evaluates
// `$slot->icon` unguarded and throws when the slot has no such property.
$hasIconLeading = (bool) ($icon ?? $slot->icon ?? $slot->iconLeading ?? false);
$hasIconTrailing = (bool) ($iconTrailing ?? $slot->iconTrailing ?? false)
    || $clearable || $copyable || ($isPassword && $viewable) || (bool) $kbd;

if ($hasIconLeading) {
    $classes = $classes->add('ps-0');
    $inputClasses = $inputClasses->add('ps-1');
}

if ($hasIconTrailing) {
    $classes = $classes->add('pe-0');
}
@endphp

@if ($isButton)
    <button type="button" {{ $attributes->class($classes) }} @if ($disabled) disabled @endif data-gsmui-input data-gsmui-control>
        @if ($hasIconLeading)
            <div class="flex items-center justify-center ms-3 me-1">
                @if ($icon)
                    <gsmui:icon :$icon variant="mini" class="text-zinc-400 dark:text-zinc-500 shrink-0" />
                @else
                    {{ $slot->icon ?? $slot->iconLeading ?? '' }}
                @endif
            </div>
        @endif

        <span class="flex-1 truncate {{ $inputClasses }}">{{ $placeholder ?? $slot }}</span>

        @if ($kbd)
            <span class="me-2 inline-flex items-center rounded-md border border-zinc-200 dark:border-white/10 px-1.5 py-0.5 text-xs text-zinc-400 dark:text-zinc-500">{{ $kbd }}</span>
        @endif
    </button>
@elseif ($isFile)
    <div {{ $attributes->class($classes) }} data-gsmui-input data-gsmui-control>
        <input type="file" {{ $attributes->only(['wire:model', 'name', 'accept', 'multiple']) }} @if ($multiple) multiple @endif class="{{ $inputClasses->add('file:me-2 file:rounded-md file:border-0 file:bg-zinc-100 file:px-2 file:py-1 file:text-sm file:font-medium file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-white/10 dark:file:text-zinc-300 dark:hover:file:bg-white/20') }}" />
    </div>
@else
    <div {{ $attributes->except(['wire:model', 'name', 'type', 'placeholder'])->class($classes) }} data-gsmui-input data-gsmui-control>
        @if ($hasIconLeading)
            <div class="flex items-center justify-center ms-3 me-1 shrink-0">
                @if ($icon)
                    <gsmui:icon :$icon variant="mini" class="text-zinc-400 dark:text-zinc-500" />
                @else
                    {{ $slot->icon ?? $slot->iconLeading ?? '' }}
                @endif
            </div>
        @endif

        <input
            type="{{ $type }}"
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($disabled) disabled @endif
            @if ($readonly) readonly @endif
            @if ($invalid) aria-invalid="true" data-invalid @endif
            {{ $attributes->only(['wire:model', 'name', 'type', 'placeholder', 'value', 'min', 'max', 'step', 'pattern', 'inputmode', 'autocomplete', 'autofocus', 'required'])->class($inputClasses) }}
        />

        @if ($hasIconTrailing)
            <div class="flex items-center gap-1 me-2 ms-1 shrink-0">
                @if ($iconTrailing)
                    <gsmui:icon :name="$iconTrailing" variant="mini" class="text-zinc-400 dark:text-zinc-500" />
                @endif

                @if ($clearable)
                    <gsmui:button as="div" variant="subtle" size="sm" square tabindex="-1" aria-label="{{ __('Clear') }}" class="cursor-pointer [[data-gsmui-input]:has(input:placeholder-shown)_&]:hidden" x-on:click.prevent="$el.closest('[data-gsmui-input]').querySelector('input').value = ''; $el.closest('[data-gsmui-input]').querySelector('input').dispatchEvent(new Event('input')); $el.closest('[data-gsmui-input]').querySelector('input').focus()">
                        <gsmui:icon.x-mark variant="micro" />
                    </gsmui:button>
                @endif

                @if ($copyable)
                    <gsmui:button as="div" variant="subtle" size="sm" square tabindex="-1" aria-label="{{ __('Copy') }}" class="cursor-pointer" x-data="{ copied: false }" x-on:click="navigator.clipboard.writeText($el.closest('[data-gsmui-input]').querySelector('input').value); copied = true; setTimeout(() => copied = false, 2000)">
                        <gsmui:icon.clipboard-document variant="mini" x-show="!copied" />
                        <gsmui:icon.check variant="mini" x-show="copied" class="text-green-500" />
                    </gsmui:button>
                @endif

                @if ($isPassword && $viewable)
                    <gsmui:button as="div" variant="subtle" size="sm" square tabindex="-1" aria-label="{{ __('Toggle password visibility') }}" class="cursor-pointer" x-data="{ show: false }" x-on:click="show = !show; $el.closest('[data-gsmui-input]').querySelector('input').type = show ? 'text' : 'password'">
                        <gsmui:icon.eye-dropper variant="mini" x-show="!show" />
                        <gsmui:icon.x-mark variant="mini" x-show="show" class="text-zinc-500" />
                    </gsmui:button>
                @endif

                @if ($kbd)
                    <span class="inline-flex items-center rounded-md border border-zinc-200 dark:border-white/10 px-1.5 py-0.5 text-xs text-zinc-400 dark:text-zinc-500">{{ $kbd }}</span>
                @endif

                {{ $slot->iconTrailing ?? '' }}
            </div>
        @endif
    </div>
@endif
