@blaze(fold: true)

@props([
    'variant' => 'outline',
    'color' => null,
    'size' => null,
    'icon' => null,
    'iconTrailing' => null,
    'iconVariant' => 'mini',
    'square' => false,
    'inset' => null,
    'disabled' => false,
    'href' => null,
    'as' => null,
    'type' => 'button',
    'kbd' => null,
    'tooltip' => null,
    'tooltipPosition' => 'top',
])

@php
$isLink = $href && $as !== 'div' && $as !== 'button';
$tag = $as ?: ($isLink ? 'a' : 'button');

$hasIcon = $icon || ($slot?->icon ?? false);
$hasIconTrailing = $iconTrailing || ($slot?->iconTrailing ?? false);
$hasWireClick = $attributes->hasWire('click');

$classes = Gsmui::classes()
    ->add('inline-flex items-center justify-center gap-2 font-semibold transition-all duration-150')
    ->add('shadow-xs')
    ->add('focus:outline-none')
    ->add($disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer')
    ->add(match ($variant) {
        'primary' => 'text-white bg-blue-600 hover:bg-blue-500 active:bg-blue-700 shadow-sm',
        'filled' => match ($color) {
            'red' => 'text-white bg-red-600 hover:bg-red-500 active:bg-red-700',
            'green' => 'text-white bg-green-600 hover:bg-green-500 active:bg-green-700',
            'zinc' => 'text-white bg-zinc-700 hover:bg-zinc-600 active:bg-zinc-800 dark:bg-zinc-600 dark:hover:bg-zinc-500',
            default => 'text-white bg-zinc-900 hover:bg-zinc-700 active:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100',
        },
        'danger' => 'text-white bg-red-600 hover:bg-red-500 active:bg-red-700 shadow-sm',
        'ghost' => 'text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-white/10 active:bg-zinc-200 dark:active:bg-white/20',
        'subtle' => 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-white/10',
        default => 'text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 active:bg-zinc-100 dark:active:bg-zinc-600',
    })
    ->add(match ($size) {
        'xs' => $square ? 'size-6' : 'h-6 rounded-md px-2 text-xs',
        'sm' => $square ? 'size-8' : 'h-8 rounded-md px-3 text-sm',
        default => $square ? 'size-10' : 'h-10 rounded-lg px-4 text-sm',
    })
    ->add($square ? 'p-0!' : '')
    ;

if ($inset) {
    $insetParts = explode(' ', $inset);
    foreach ($insetParts as $part) {
        $classes = $classes->add(match ($part) {
            'top' => '-mt-1',
            'bottom' => '-mb-1',
            'left' => '-ml-1',
            'right' => '-mr-1',
            default => '',
        });
    }
}

// Handle wire:click loading state — disable button while Livewire action is in flight
if ($hasWireClick) {
    $attributes = $attributes->merge(['wire:loading.attr' => 'disabled', 'wire:target' => $attributes->wire('click')->value]);
}

@endphp

@if ($tooltip)
    <gsmui:tooltip :content="$tooltip" :position="$tooltipPosition" class="contents">
        <{{ $tag }}
            @if ($tag === 'button') type="{{ $type }}" @if ($disabled) disabled @endif
            @elseif ($tag === 'a') href="{{ $href }}"
            @endif
            {{ $attributes->class($classes) }}
            data-gsmui-button
        >
            @if ($hasIcon)
                <span class="flex items-center shrink-0">
                    @if ($icon)
                        <gsmui:icon :name="$icon" :variant="$iconVariant" />
                    @else
                        {{ $slot?->icon ?? '' }}
                    @endif
                </span>
            @endif

            @if ($slot->isNotEmpty() && !$square)
                <span class="truncate">{{ $slot }}</span>
            @endif

            @if ($hasIconTrailing)
                <span class="flex items-center shrink-0">
                    @if ($iconTrailing)
                        <gsmui:icon :name="$iconTrailing" :variant="$iconVariant" />
                    @else
                        {{ $slot?->iconTrailing ?? '' }}
                    @endif
                </span>
            @endif

            @if ($kbd && !$square)
                <span class="hidden sm:inline-flex items-center rounded-md border border-zinc-200 dark:border-white/10 px-1.5 py-0.5 text-xs text-zinc-400 dark:text-zinc-500 ms-2">{{ $kbd }}</span>
            @endif
        </{{ $tag }}>
    </gsmui:tooltip>
@else
    <{{ $tag }}
        @if ($tag === 'button') type="{{ $type }}" @if ($disabled) disabled @endif
        @elseif ($tag === 'a') href="{{ $href }}"
        @endif
        {{ $attributes->class($classes) }}
        data-gsmui-button
    >
        @if ($hasIcon)
            <span class="flex items-center shrink-0">
                @if ($icon)
                    <gsmui:icon :name="$icon" :variant="$iconVariant" />
                @else
                    {{ $slot?->icon ?? '' }}
                @endif
            </span>
        @endif

        @if ($slot->isNotEmpty() && !$square)
            <span class="truncate">{{ $slot }}</span>
        @endif

        @if ($hasIconTrailing)
            <span class="flex items-center shrink-0">
                @if ($iconTrailing)
                    <gsmui:icon :name="$iconTrailing" :variant="$iconVariant" />
                @else
                    {{ $slot?->iconTrailing ?? '' }}
                @endif
            </span>
        @endif

        @if ($kbd && !$square)
            <span class="hidden sm:inline-flex items-center rounded-md border border-zinc-200 dark:border-white/10 px-1.5 py-0.5 text-xs text-zinc-400 dark:text-zinc-500 ms-2">{{ $kbd }}</span>
        @endif
    </{{ $tag }}>
@endif
