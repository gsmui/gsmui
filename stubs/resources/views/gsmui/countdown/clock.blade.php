@blaze(fold: true)

@props([
    'days' => null,
    'hours' => null,
    'minutes' => null,
    'seconds' => null,
    'showLabels' => true,
    'size' => null,
    'color' => null,
    'variant' => null,
    'gap' => null,
])

@php
$hasDays = $days !== null;
$hasHours = $hours !== null;
$hasMinutes = $minutes !== null;
$hasSeconds = $seconds !== null;
$containerClasses = Gsmui::classes()
    ->add('flex items-center')
    ->add(match ($gap) {
        'sm' => 'gap-1.5',
        'lg' => 'gap-4',
        'xl' => 'gap-6',
        default => 'gap-2.5',
    })
    ;

$sepClasses = Gsmui::classes()
    ->add('font-mono tabular-nums')
    ->add(match ($size) {
        'xs' => 'text-base',
        'sm' => 'text-xl',
        'lg' => 'text-5xl',
        'xl' => 'text-7xl',
        default => 'text-3xl',
    })
    ->add('text-zinc-300 dark:text-zinc-600')
    ;

$unitSize = match ($size) {
    'xs' => 'xs',
    'sm' => 'sm',
    'lg' => 'lg',
    'xl' => 'xl',
    default => null,
};

$labelMap = ['days' => __('Days'), 'hours' => __('Hours'), 'minutes' => __('Minutes'), 'seconds' => __('Seconds')];
@endphp

<div {{ $attributes->class($containerClasses) }} data-gsmui-countdown-clock>
    @if ($hasDays)
        <gsmui:countdown.block :value="$days" digits="2" :label="$showLabels ? $labelMap['days'] : null" :size="$unitSize" :$color :$variant />
        @if ($hasHours)
            <span class="{{ $sepClasses }}">:</span>
        @endif
    @endif

    @if ($hasHours)
        <gsmui:countdown.block :value="$hours" digits="2" :label="$showLabels ? $labelMap['hours'] : null" :size="$unitSize" :$color :$variant />
        @if ($hasMinutes)
            <span class="{{ $sepClasses }}">:</span>
        @endif
    @endif

    @if ($hasMinutes)
        <gsmui:countdown.block :value="$minutes" digits="2" :label="$showLabels ? $labelMap['minutes'] : null" :size="$unitSize" :$color :$variant />
        @if ($hasSeconds)
            <span class="{{ $sepClasses }}">:</span>
        @endif
    @endif

    @if ($hasSeconds)
        <gsmui:countdown.block :value="$seconds" digits="2" :label="$showLabels ? $labelMap['seconds'] : null" :size="$unitSize" :$color :$variant />
    @endif
</div>
