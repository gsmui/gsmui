@blaze(fold: true)

@props([
    'name' => null,
    'customMessage' => null,
    'bag' => 'default',
    'deep' => true,
    'icon' => 'exclamation-triangle',
])

@php
$errorName = $name ?: $attributes->get('name');
$showIcon = $icon !== false && $icon !== 'false';
@endphp

@error($errorName, $bag)
    <div {{ $attributes->class('flex items-center gap-1.5 mt-1.5 text-sm text-red-600 dark:text-red-400') }} data-gsmui-error>
        @if ($showIcon)
            <gsmui:icon :name="$icon" variant="micro" class="shrink-0" />
        @endif
        <span>{{ $customMessage ?? $message }}</span>
    </div>
@enderror
