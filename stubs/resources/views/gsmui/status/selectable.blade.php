@props([
    'label' => 'Selectable',
    'selected' => false,
    'size' => 'md',
])

$sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-sm', 'lg' => 'px-3 py-1.5 text-base'];
@endphp

<span {{ $attributes->class([
    'inline-flex items-center font-medium rounded-md cursor-pointer transition-all',
    $selected 
        ? 'bg-blue-500 text-white shadow-sm' 
        : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-zinc-700',
    $sizes[$size] ?? $sizes['md'],
]) }}>
    {{ $label }}
</span>
