@blaze(fold: true)

@props([
    'variant' => 'bezel',
    'color' => null,
    'size' => null,
    'orientation' => null,
])

@php
$isLandscape = $orientation === 'landscape';

$classes = Gsmui::classes()
    ->add('relative inline-flex flex-col items-center select-none')
    ->add(match ($size) {
        'sm' => $isLandscape ? 'w-80' : 'w-56',
        'lg' => $isLandscape ? 'w-120' : 'w-80',
        'xl' => $isLandscape ? 'w-144' : 'w-96',
        default => $isLandscape ? 'w-96' : 'w-64',
    })
    ;

$bezelClasses = Gsmui::classes()
    ->add('relative w-full overflow-hidden')
    ->add(match ($variant) {
        'flat' => 'rounded-xl',
        'minimal' => 'rounded-[1.5rem]',
        default => 'rounded-[2rem]',
    })
    ->add(match ($color) {
        'zinc' => 'bg-zinc-800 dark:bg-zinc-700',
        'red' => 'bg-red-800',
        'orange' => 'bg-orange-700',
        'amber' => 'bg-amber-700',
        'yellow' => 'bg-yellow-600',
        'lime' => 'bg-lime-700',
        'green' => 'bg-green-700',
        'emerald' => 'bg-emerald-700',
        'teal' => 'bg-teal-700',
        'cyan' => 'bg-cyan-700',
        'sky' => 'bg-sky-700',
        'blue' => 'bg-blue-700',
        'indigo' => 'bg-indigo-700',
        'violet' => 'bg-violet-700',
        'purple' => 'bg-purple-700',
        'fuchsia' => 'bg-fuchsia-700',
        'pink' => 'bg-pink-700',
        'rose' => 'bg-rose-700',
        'slate' => 'bg-slate-800 dark:bg-slate-700',
        'space-gray' => 'bg-zinc-900',
        'silver' => 'bg-zinc-300 dark:bg-zinc-400',
        'gold' => 'bg-amber-400 dark:bg-amber-500',
        default => 'bg-zinc-900 dark:bg-zinc-800',
    })
    ->add(match ($variant) {
        'flat' => 'p-0 shadow-lg',
        'minimal' => 'p-1.5 shadow-2xl',
        default => 'p-2.5 shadow-2xl',
    })
    ;

$displayClasses = Gsmui::classes()
    ->add('relative overflow-hidden bg-white dark:bg-zinc-900')
    ->add(match ($variant) {
        'flat' => 'rounded-xl',
        'minimal' => 'rounded-[1.25rem]',
        default => 'rounded-[1.65rem]',
    })
    ;
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-tablet>
    <div class="{{ $bezelClasses }}">
        <div class="{{ $displayClasses }}">
            {{ $slot }}
        </div>
    </div>
</div>
