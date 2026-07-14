@blaze(fold: true)

@props([
    'variant' => null,
    'color' => 'zinc',
    'size' => null,
    'icon' => null,
    'iconTrailing' => null,
    'iconVariant' => 'mini',
    'rounded' => false,
    'as' => null,
])

@php
$isButton = $as === 'button';
$tag = $isButton ? 'button' : 'span';

$classes = Gsmui::classes()
    ->add('inline-flex items-center gap-1 font-medium')
    ->add($rounded ? 'rounded-full' : 'rounded-md')
    ->add(match ($variant) {
        'solid' => match ($color) {
            'zinc' => 'bg-zinc-700 text-white dark:bg-zinc-600',
            'red' => 'bg-red-600 text-white',
            'orange' => 'bg-orange-600 text-white',
            'amber' => 'bg-amber-600 text-white',
            'yellow' => 'bg-yellow-600 text-white',
            'lime' => 'bg-lime-600 text-white',
            'green' => 'bg-green-600 text-white',
            'emerald' => 'bg-emerald-600 text-white',
            'teal' => 'bg-teal-600 text-white',
            'cyan' => 'bg-cyan-600 text-white',
            'sky' => 'bg-sky-600 text-white',
            'blue' => 'bg-blue-600 text-white',
            'indigo' => 'bg-indigo-600 text-white',
            'violet' => 'bg-violet-600 text-white',
            'purple' => 'bg-purple-600 text-white',
            'fuchsia' => 'bg-fuchsia-600 text-white',
            'pink' => 'bg-pink-600 text-white',
            'rose' => 'bg-rose-600 text-white',
            default => 'bg-zinc-700 text-white dark:bg-zinc-600',
        },
        default => match ($color) {
            'zinc' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
            'red' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
            'orange' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300',
            'amber' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
            'yellow' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
            'lime' => 'bg-lime-100 text-lime-700 dark:bg-lime-900/30 dark:text-lime-300',
            'green' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
            'emerald' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
            'teal' => 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-300',
            'cyan' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-300',
            'sky' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
            'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
            'indigo' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
            'violet' => 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-300',
            'purple' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300',
            'fuchsia' => 'bg-fuchsia-100 text-fuchsia-700 dark:bg-fuchsia-900/30 dark:text-fuchsia-300',
            'pink' => 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300',
            'rose' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
            default => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
        },
    })
    ->add(match ($size) {
        'sm' => 'px-1.5 py-0.5 text-xs',
        'lg' => 'px-3 py-1 text-sm',
        default => 'px-2 py-0.5 text-xs',
    })
    ->add($isButton ? 'hover:opacity-80 active:opacity-70' : '')
    ;
@endphp

<{{ $tag }} {{ $attributes->class($classes) }} data-gsmui-badge>
    @if ($icon)
        <gsmui:icon :name="$icon" variant="micro" />
    @endif
    {{ $slot }}
    @if ($iconTrailing)
        <gsmui:icon :name="$iconTrailing" variant="micro" />
    @endif
</{{ $tag }}>
