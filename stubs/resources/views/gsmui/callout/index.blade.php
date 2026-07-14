@blaze(fold: true)

@props([
    'variant' => 'info',
    'icon' => null,
    'title' => null,
    'dismissible' => false,
])

@php
$iconMap = [
    'info' => 'information-circle',
    'warning' => 'exclamation-triangle',
    'success' => 'check-circle',
    'danger' => 'x-circle',
    'tip' => 'light-bulb',
    'note' => 'pencil',
];

$classes = Gsmui::classes()
    ->add('relative flex gap-3 rounded-xl p-4 border')
    ->add(match ($variant) {
        'warning' => 'bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-800/40 text-amber-800 dark:text-amber-200',
        'success' => 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800/40 text-emerald-800 dark:text-emerald-200',
        'danger' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800/40 text-red-800 dark:text-red-200',
        'tip' => 'bg-sky-50 dark:bg-sky-900/20 border-sky-200 dark:border-sky-800/40 text-sky-800 dark:text-sky-200',
        'note' => 'bg-zinc-50 dark:bg-zinc-800/30 border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300',
        default => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800/40 text-blue-800 dark:text-blue-200',
    })
    ;

$iconClasses = Gsmui::classes()
    ->add('shrink-0 mt-0.5 size-5')
    ->add(match ($variant) {
        'warning' => 'text-amber-500 dark:text-amber-400',
        'success' => 'text-emerald-500 dark:text-emerald-400',
        'danger' => 'text-red-500 dark:text-red-400',
        'tip' => 'text-sky-500 dark:text-sky-400',
        'note' => 'text-zinc-400 dark:text-zinc-500',
        default => 'text-blue-500 dark:text-blue-400',
    })
    ;

$iconName = $icon ?: ($iconMap[$variant] ?? 'information-circle');
@endphp

<div
    {{ $attributes->class($classes) }}
    @if ($dismissible)
        x-data="{ dismissed: false }"
        x-show="!dismissed"
        x-cloak
    @endif
    data-gsmui-callout
    role="alert"
>
    <gsmui:icon :name="$iconName" variant="solid" class="{{ $iconClasses }}" />

    <div class="flex-1 min-w-0">
        @if ($title)
            <p class="text-sm font-semibold mb-1">{{ $title }}</p>
        @endif

        <div class="text-sm leading-relaxed opacity-90">
            {{ $slot }}
        </div>
    </div>

    @if ($dismissible)
        <gsmui:button
            variant="subtle"
            size="xs"
            square
            @click="dismissed = true"
            aria-label="{{ __('Dismiss') }}"
            class="shrink-0 self-start -me-1 -mt-1"
        >
            <gsmui:icon.x-mark variant="mini" class="size-4" />
        </gsmui:button>
    @endif
</div>
