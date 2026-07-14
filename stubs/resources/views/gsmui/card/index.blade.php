@blaze(fold: true)

@props([
    'variant' => 'default',
    'size' => null,
    'padding' => null,
    'as' => null,
    'href' => null,
])

@php
$isLink = $href && $as !== 'div';
$tag = $as ?: ($isLink ? 'a' : 'div');

// Extract slot presence to variables (avoids double rendering and complex inline ternaries)
$hasImage = ($slot?->image ?? false) !== false;
$hasHeader = ($slot?->header ?? false) !== false;
$hasFooter = ($slot?->footer ?? false) !== false;
$bodyOnly = !$hasImage && !$hasHeader && !$hasFooter;

$paddingClasses = match ($padding) {
    'sm' => 'p-3',
    'lg' => 'p-6',
    'none' => 'p-0',
    default => 'p-4',
};

// Determine body padding based on which slots are present
if ($bodyOnly) {
    $bodyClasses = $paddingClasses;
} elseif ($hasHeader && $hasFooter) {
    $bodyClasses = $paddingClasses . ' flex-1';
} elseif ($hasHeader) {
    $bodyClasses = $paddingClasses;
} elseif ($hasFooter) {
    $bodyClasses = $paddingClasses . ' flex-1';
} elseif ($hasImage) {
    $bodyClasses = $paddingClasses;
} else {
    $bodyClasses = $paddingClasses;
}

$classes = Gsmui::classes()
    ->add('flex flex-col overflow-hidden')
    ->add(match ($variant) {
        'outlined' => 'border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900',
        'flat' => 'bg-zinc-50 dark:bg-zinc-800/50',
        'elevated' => 'bg-white dark:bg-zinc-900 shadow-lg shadow-zinc-200/50 dark:shadow-zinc-900/50',
        'interactive' => 'border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm hover:shadow-md hover:border-zinc-300 dark:hover:border-zinc-600 transition-all duration-200',
        'ghost' => 'bg-transparent hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-150',
        default => 'border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm',
    })
    ->add(match ($size) {
        'sm' => 'rounded-lg',
        'lg' => 'rounded-2xl',
        default => 'rounded-xl',
    })
    ->add($isLink ? 'hover:opacity-90' : '')
    ;
@endphp

<{{ $tag }}
    @if ($isLink) href="{{ $href }}" @endif
    {{ $attributes->class($classes) }}
    data-gsmui-card
>
    @if ($hasImage)
        <div {{ $slot->image->attributes->class('w-full overflow-hidden') }}>
            {{ $slot->image }}
        </div>
    @endif

    @if ($hasHeader)
        <div {{ $slot->header->attributes->class($paddingClasses . ' border-b border-zinc-100 dark:border-zinc-800') }}>
            {{ $slot->header }}
        </div>
    @endif

    <div class="{{ $bodyClasses }}" data-gsmui-card-body>
        {{ $slot }}
    </div>

    @if ($hasFooter)
        <div {{ $slot->footer->attributes->class($paddingClasses . ' border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30') }}>
            {{ $slot->footer }}
        </div>
    @endif
</{{ $tag }}>
