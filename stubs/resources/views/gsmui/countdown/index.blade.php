@blaze(fold: true)

@props([
    'value' => 0,
    'digits' => 2,
    'label' => null,
    'size' => null,
    'color' => null,
    'ariaLabel' => null,
])

@php
$displayValue = max(0, min(999, (int) $value));
$digitCount = max(1, min(3, (int) $digits));

$classes = Gsmui::classes()
    ->add('countdown font-mono tabular-nums')
    ->add(match ($size) {
        'xs' => 'text-lg',
        'sm' => 'text-2xl',
        'lg' => 'text-6xl',
        'xl' => 'text-8xl',
        default => 'text-4xl',
    })
    ->add(match ($color) {
        'primary' => 'text-blue-600 dark:text-blue-400',
        'secondary' => 'text-violet-600 dark:text-violet-400',
        'accent' => 'text-amber-500 dark:text-amber-400',
        'success' => 'text-emerald-600 dark:text-emerald-400',
        'warning' => 'text-amber-600 dark:text-amber-400',
        'danger' => 'text-red-600 dark:text-red-400',
        'info' => 'text-sky-600 dark:text-sky-400',
        'neutral' => 'text-zinc-700 dark:text-zinc-300',
        default => 'text-zinc-900 dark:text-white',
    })
    ;

$padded = str_pad($displayValue, $digitCount, '0', STR_PAD_LEFT);
$ariaLabel = $ariaLabel ?: $padded;
@endphp

<span {{ $attributes->class($classes) }} data-gsmui-countdown aria-live="polite" aria-label="{{ $ariaLabel }}">
    <span style="--value: {{ $displayValue }}; --digits: {{ $digitCount }};">
        {{ $padded }}
    </span>
    @if ($label)
        <span class="text-xs font-sans ms-0.5 text-zinc-500 dark:text-zinc-400">{{ $label }}</span>
    @endif
</span>
