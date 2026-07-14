@blaze(fold: true)

@props([
    'variant' => 'default',
    'color' => null,
    'size' => null,
    'compact' => false,
])

@php
$classes = Gsmui::classes()
    ->add('relative inline-flex flex-col w-full font-mono select-none')
    ->add(match ($size) {
        'sm' => 'max-w-md',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        default => 'max-w-xl',
    })
    ;

$boardClasses = Gsmui::classes()
    ->add('relative w-full overflow-hidden')
    ->add(match ($variant) {
        'flat' => 'rounded-xl p-3 bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700',
        'minimal' => 'rounded-2xl p-4 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 shadow-sm',
        'retro' => 'rounded-2xl p-4 bg-amber-50 dark:bg-amber-950 border-2 border-amber-200 dark:border-amber-800 shadow-lg shadow-amber-900/10',
        'gaming' => 'rounded-xl p-3 bg-zinc-900 border-2 border-zinc-700 shadow-xl shadow-violet-900/20',
        default => 'rounded-2xl p-4 bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 shadow-lg',
    })
    ->add($compact ? 'p-2 gap-1' : 'space-y-1.5')
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-kbd-board>
    <div class="{{ $boardClasses }}">
        {{ $slot }}
    </div>
</div>
