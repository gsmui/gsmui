@blaze(fold: true, unsafe: [
    // variant props
    'kbd', 'icon', 'iconVariant',
    'icon:variant',
])

@aware(['variant' => null])

@props([
    'items' => null,
    'variant' => null,
])

@php
$classes = Gsmui::classes()
    ->add('block overflow-x-auto w-full')
    ->add(match($variant) {
        'borderless' => 'rounded-lg bg-zinc-100 dark:bg-white/10 *:p-1.5 *:h-auto',
        default => [
            'bg-zinc-50 dark:bg-white/[6%] dark:border-white/5',
            'rounded-t-[calc(0.5rem-1px)]',
            'border-b border-zinc-200 dark:border-white/10',
        ]
    })
;
@endphp

<ui-toolbar {{ $attributes->class($classes) }} wire:ignore aria-label="{{ __('Formatting') }}">
    <div class="h-10 p-2 flex gap-2 items-center">
        <?php if ($slot->isNotEmpty()): ?>
            {{ $slot }}
        <?php else: ?>
            <?php if ($items !== null): ?>
                <?php foreach (str($items)->explode(' ') as $item): ?>
                    <?php if ($item === '|') $item = 'separator'; ?>
                    <?php if ($item === '~') $item = 'spacer'; ?>
                    <gsmui:delegate-component :component="'editor.' . $item"></gsmui:delegate-component>
                <?php endforeach; ?>
            <?php else: ?>
                <gsmui:editor.heading />
                <gsmui:editor.separator />
                <gsmui:editor.bold />
                <gsmui:editor.italic />
                <gsmui:editor.strike />
                <gsmui:editor.separator />
                <gsmui:editor.bullet />
                <gsmui:editor.ordered />
                <gsmui:editor.blockquote />
                <gsmui:editor.separator />
                <gsmui:editor.link />
                <gsmui:editor.separator />
                <gsmui:editor.align />
            <?php endif; ?>
        <?php endif; ?>
    </div>
</ui-toolbar>
