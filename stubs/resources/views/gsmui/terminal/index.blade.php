@blaze(fold: true)

@props([
    'variant' => 'modern',
    'color' => null,
    'size' => null,
])

@php
$classes = Gsmui::classes()
    ->add('relative inline-flex flex-col w-full font-mono select-none')
    ->add(match ($size) {
        'sm' => 'max-w-xl text-xs',
        'lg' => 'max-w-5xl text-base',
        'xl' => 'max-w-7xl text-lg',
        default => 'max-w-3xl text-sm',
    })
    ;

$bezelClasses = Gsmui::classes()
    ->add('relative w-full overflow-hidden')
    ->add(match ($variant) {
        'vintage' => 'rounded-xl border-2 border-zinc-500 dark:border-zinc-600 shadow-lg shadow-green-900/20 dark:shadow-green-500/5 bg-zinc-800 p-2',
        'crt' => 'rounded-[2rem] border-4 border-zinc-700 dark:border-zinc-600 shadow-2xl shadow-green-900/30 dark:shadow-green-500/10 bg-zinc-900 p-3',
        'modern' => 'rounded-xl border border-zinc-700 shadow-xl bg-zinc-900 p-0',
        'retro' => 'rounded border-4 border-amber-900/50 dark:border-amber-700/30 shadow-2xl bg-amber-950 p-3',
        default => 'rounded-xl border border-zinc-700 shadow-xl bg-zinc-900 p-0',
    })
    ;

$screenClasses = Gsmui::classes()
    ->add('relative overflow-hidden')
    ->add(match ($variant) {
        'vintage' => 'rounded-lg bg-green-950 p-4 text-green-400',
        'crt' => 'rounded-[1.75rem] bg-green-950 p-5 text-green-400',
        'modern' => 'rounded-xl bg-zinc-950 p-4 text-green-400',
        'retro' => 'rounded bg-amber-950 p-4 text-amber-400',
        default => 'rounded-xl bg-zinc-950 p-4 text-green-400',
    })
    ->add(match ($color) {
        'amber' => 'text-amber-400',
        'white' => 'text-zinc-100',
        'blue' => 'text-sky-300',
        'matrix' => 'text-green-500',
        default => 'text-green-400',
    })
    ;

// CRT scan line overlay for vintage/crt variants
$scanLines = in_array($variant, ['crt', 'vintage']);
@endphp

<div {{ $attributes->class($classes) }} data-gsmui-terminal>
    <div class="{{ $bezelClasses }}">
        <div class="{{ $screenClasses }}">
            @if ($scanLines)
                <div class="absolute inset-0 pointer-events-none z-10 opacity-[0.03] dark:opacity-[0.05]" style="background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,.08) 2px, rgba(255,255,255,.08) 4px)"></div>
            @endif

            <div class="relative leading-relaxed">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
