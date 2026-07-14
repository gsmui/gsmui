@blaze(fold: true)

@props([
    'icon' => 'x-mark',
    'iconVariant' => 'mini',
])

<button {{ $attributes->class('inline-flex items-center justify-center -me-1 -my-1 rounded-full p-0.5 hover:bg-black/10 dark:hover:bg-white/10 transition-colors') }} type="button" aria-label="{{ __('Remove') }}" data-gsmui-badge-close>
    <gsmui:icon :name="$icon" :variant="$iconVariant" class="size-3" />
</button>
