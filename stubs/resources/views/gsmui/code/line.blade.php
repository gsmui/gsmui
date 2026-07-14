@blaze(fold: true)

@props([
    'prefix' => null,
    'color' => null,
    'highlight' => false,
    'indent' => 0,
    'wrap' => false,
])

@php
$classes = Gsmui::classes()
    ->add('flex')
    ->add($highlight ? 'bg-zinc-800 dark:bg-zinc-700/50 -mx-4 px-4' : '')
    ;

$prefixClasses = Gsmui::classes()
    ->add('shrink-0 select-none')
    ->add(match ($color) {
        'muted' => 'text-zinc-500 dark:text-zinc-600',
        'info' => 'text-sky-400',
        'success' => 'text-green-400',
        'warning' => 'text-amber-400',
        'danger' => 'text-red-400',
        'comment' => 'text-zinc-500 dark:text-zinc-600 italic',
        default => 'text-zinc-500',
    })
    ;

$textClasses = Gsmui::classes()
    ->add('whitespace-pre')
    ->add($wrap ? 'whitespace-pre-wrap break-all' : '')
    ->add(match ($color) {
        'muted' => 'text-zinc-500 dark:text-zinc-600',
        'info' => 'text-sky-300',
        'success' => 'text-green-300',
        'warning' => 'text-amber-300',
        'danger' => 'text-red-300',
        'comment' => 'text-zinc-500 dark:text-zinc-600 italic',
        'keyword' => 'text-purple-300',
        'string' => 'text-green-300',
        'number' => 'text-amber-300',
        'function' => 'text-sky-300',
        'variable' => 'text-rose-300',
        'operator' => 'text-zinc-400',
        default => '',
    })
    ;

$prefixWidth = $prefix ? 'w-8' : 'w-0';
$indentStr = str_repeat('    ', max(0, (int)$indent));
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-code-line>
    @if ($prefix !== null)
        <span class="{{ $prefixClasses }} {{ $prefixWidth }} text-right mr-3">
            {{ $prefix }}
        </span>
    @endif
    <span class="{{ $textClasses }}">
        {{ $indentStr }}{{ $slot }}
    </span>
</div>
