@blaze(fold: true)

@props([
    'name' => null,
    'label' => null,
    'badge' => null,
    'description' => null,
    'descriptionTrailing' => null,
    'errorName' => null,
    'errorBag' => 'default',
    'errorMessage' => null,
    'errorIcon' => 'exclamation-triangle',
    'errorDeep' => true,
    'labelBadge' => null,
    'labelAside' => null,
    'labelTrailing' => null,
])

@php
// Extract label, description, badge from attributes for shorthand API...
$label = $label ?: $attributes->get('label');
$description = $description ?: $attributes->get('description');
$descriptionTrailing = $descriptionTrailing ?: $attributes->get('description:trailing');
$badge = $badge ?: $attributes->get('badge');
$labelBadge = $labelBadge ?: $attributes->get('label:badge');

$fieldName = $name ?: $attributes->whereStartsWith('wire:model')->first();
$showLabel = $label || $labelBadge || $labelAside || $labelTrailing || $slot->label ?? false;
$showDescription = $description || $descriptionTrailing;
$showError = $fieldName && $errors->has($fieldName);
@endphp

<div {{ $attributes->class('block') }} data-gsmui-with-field>
    @if ($showLabel)
        <div class="flex items-center justify-between mb-1.5">
            <gsmui:field.label :badge="$labelBadge ?? $badge">
                {{ $label ?? $slot->label ?? '' }}
            </gsmui:field.label>
            @if ($labelTrailing || $labelAside)
                <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $labelTrailing ?? $labelAside ?? '' }}</div>
            @endif
        </div>
    @endif

    {{ $slot }}

    @if ($showDescription && !$descriptionTrailing)
        <gsmui:field.description>{{ $description }}</gsmui:field.description>
    @endif

    @if ($showError)
        <gsmui:field.error :name="$fieldName" :bag="$errorBag" :customMessage="$errorMessage" :icon="$errorIcon" :deep="$errorDeep" />
    @endif

    @if ($descriptionTrailing)
        <gsmui:field.description>{{ $descriptionTrailing }}</gsmui:field.description>
    @endif
</div>
