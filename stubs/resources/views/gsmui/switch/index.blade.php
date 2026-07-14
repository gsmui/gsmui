@blaze(fold: true, unsafe: [
    'name', 'label', 'badge',
    'description', 'description:trailing',
    'label:badge', 'label:aside', 'label:trailing',
    'error:name', 'error:bag', 'error:message', 'error:icon', 'error:nested', 'error:deep',
])

@props([
    'label' => null,
    'description' => null,
    'align' => 'right',
    'disabled' => false,
    'invalid' => false,
    'name' => null,
])

@php
$name ??= $attributes->whereStartsWith('wire:model')->first();

$isLeft = $align === 'left' || $align === 'start';

$wrapperClasses = Gsmui::classes()
    ->add('flex items-center')
    ->add($isLeft ? 'flex-row-reverse justify-end' : 'justify-between')
    ->add('gap-3')
    ;

$switchClasses = Gsmui::classes()
    ->add('relative inline-flex h-6 w-11 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out')
    ->add($disabled ? 'opacity-60 cursor-not-allowed' : 'cursor-pointer')
    ->add('bg-zinc-200 dark:bg-zinc-600')
    ->add('peer-checked:bg-blue-600 dark:peer-checked:bg-blue-500')
    ->add('focus:ring-2 focus:ring-blue-500/30 focus:ring-offset-0')
    ;

$thumbClasses = Gsmui::classes()
    ->add('pointer-events-none inline-block size-5 translate-x-0 rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out')
    ->add('peer-checked:translate-x-5')
    ;
@endphp

<gsmui:with-field :$attributes :$name>
    <label {{ $attributes->except(['wire:model', 'label', 'description', 'align'])->class($wrapperClasses) }} data-gsmui-switch>
        <input
            type="checkbox"
            role="switch"
            @if ($disabled) disabled @endif
            @if ($invalid) data-invalid @endif
            {{ $attributes->only(['wire:model', 'name', 'checked']) }}
            class="peer sr-only"
        />

        <span class="{{ $switchClasses }}">
            <span class="{{ $thumbClasses }}" aria-hidden="true"></span>
        </span>

        @if ($label || $description || $slot->isNotEmpty())
            <div class="flex-1">
                @if ($slot->isNotEmpty())
                    {{ $slot }}
                @else
                    @if ($label)
                        <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $label }}</span>
                    @endif
                    @if ($description)
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $description }}</p>
                    @endif
                @endif
            </div>
        @endif
    </label>
</gsmui:with-field>
