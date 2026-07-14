@props([
    'label' => 'Dark',
    'size' => 'md',
])

$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-md bg-zinc-900 dark:bg-white text-white dark:text-zinc-900', $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
