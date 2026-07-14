@blaze(fold: true)

@props([
    'label' => null,
    'description' => null,
    'value' => null,
    'checked' => false,
    'indeterminate' => false,
    'disabled' => false,
    'invalid' => false,
    'icon' => null,
])

@php
$classes = Gsmui::classes()
    ->add('relative flex items-start gap-3')
    ->add($disabled ? 'opacity-60' : 'cursor-pointer group')
    ;

$inputClasses = Gsmui::classes()
    ->add('peer mt-0.5 size-4 shrink-0 rounded border-2')
    ->add($invalid
        ? 'border-red-500'
        : 'border-zinc-300 dark:border-zinc-500'
    )
    ->add('bg-white dark:bg-zinc-800')
    ->add('checked:border-blue-600 checked:bg-blue-600 dark:checked:border-blue-500 dark:checked:bg-blue-500')
    ->add('indeterminate:border-blue-600 indeterminate:bg-blue-600 dark:indeterminate:border-blue-500 dark:indeterminate:bg-blue-500')
    ->add('focus:ring-2 focus:ring-blue-500/30 focus:ring-offset-0')
    ->add('disabled:cursor-not-allowed disabled:opacity-50')
    ;
@endphp

<label {{ $attributes->except(['checked', 'value', 'wire:model'])->class($classes) }} data-gsmui-checkbox>
    <input
        type="checkbox"
        @if ($value) value="{{ $value }}" @endif
        @if ($checked) checked @endif
        @if ($disabled) disabled @endif
        @if ($invalid) data-invalid @endif
        {{ $attributes->only(['wire:model', 'name']) }}
        class="{{ $inputClasses }}"
        @if ($indeterminate) x-init="$el.indeterminate = true" @endif
    />

    @if ($slot->isNotEmpty())
        <div class="flex-1">
            {{ $slot }}
        </div>
    @elseif ($label || $description)
        <div class="flex-1">
            @if ($icon)
                <gsmui:icon :$icon variant="micro" class="inline-block mr-1.5 text-zinc-400 dark:text-zinc-500" />
            @endif
            @if ($label)
                <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $label }}</span>
            @endif
            @if ($description)
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $description }}</p>
            @endif
        </div>
    @endif
</label>
