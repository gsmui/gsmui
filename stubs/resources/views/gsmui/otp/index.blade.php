@blaze(fold: true)

@props([
    'length' => 6,
    'autofocus' => true,
    'paste' => true,
    'disabled' => false,
    'invalid' => false,
    'name' => null,
])

@php
$classes = Gsmui::classes()
    ->add('flex items-center gap-2')
    ->add($invalid ? 'text-red-500' : '')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-otp>
    @for ($i = 0; $i < $length; $i++)
        <input
            type="text"
            inputmode="numeric"
            maxlength="1"
            autocomplete="one-time-code"
            @if ($autofocus && $i === 0) autofocus @endif
            @if ($disabled) disabled @endif
            @if ($invalid) data-invalid @endif
            {{ $attributes->only(['wire:model', 'name']) }}
            class="
                size-10 rounded-lg border text-center text-base tabular-nums
                {{ $invalid
                    ? 'border-red-500 bg-red-50 dark:bg-red-950/20 dark:border-red-400'
                    : 'border-zinc-300 bg-white dark:border-zinc-600 dark:bg-zinc-800'
                }}
                focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none
                disabled:cursor-not-allowed disabled:opacity-50
                [[data-gsmui-otp-input]:focus]:z-10
            "
            x-on:input="$event.target.value = $event.target.value.replace(/[^0-9]/g, ''); if ($event.target.value && $el.nextElementSibling) $el.nextElementSibling.focus()"
            x-on:keydown.backspace.prevent="if (!$event.target.value && $el.previousElementSibling) $el.previousElementSibling.focus()"
            x-on:paste="{{ $paste ? 'const text = ($event.clipboardData || window.clipboardData).getData(\"text\"); const digits = text.replace(/\\D/g, \"\").slice(0, ' . $length . '); Array.from($el.closest(\'[data-gsmui-otp]\').querySelectorAll(\'input\')).forEach((input, i) => { input.value = digits[i] || \"\" }); $dispatch(\'input\', digits)' : '' }}"
            x-on:focus="$el.select()"
        />
    @endfor
</div>
