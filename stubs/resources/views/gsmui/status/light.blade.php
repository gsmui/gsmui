@props([
    'label' => 'Light',
    'size' => 'md',
])

$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class(['inline-flex items-center font-medium rounded-md bg-white dark:bg-zinc-100 text-zinc-900 dark:text-zinc-900 border border-zinc-200', $sizes[$size] ?? $sizes['md']]) }}>
    {{ $label }}
</span>
