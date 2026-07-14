@blaze(fold: true)

@props([
    'variant' => null,
    'href' => '#',
    'external' => false,
    'as' => null,
])

@php
$classes = Gsmui::classes()
    ->add(match ($variant) {
        'ghost' => 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white underline-offset-2 hover:underline',
        'subtle' => 'text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-400 underline-offset-2 hover:underline',
        default => 'text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 underline-offset-2 hover:underline',
    })
    ->add('inline-flex items-center gap-1 transition-colors duration-150 cursor-pointer')
    ;

$tag = $as === 'button' ? 'button' : 'a';
@endphp

@if ($tag === 'button')
    <button {{ $attributes->class($classes) }} data-gsmui-link type="button">{{ $slot }}</button>
@else
    <a {{ $attributes->class($classes) }} href="{{ $href }}" @if ($external) target="_blank" rel="noopener noreferrer" @endif data-gsmui-link>{{ $slot }}</a>
@endif
