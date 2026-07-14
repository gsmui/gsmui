@blaze(fold: true)

@props([
    'sortable' => false,
    'sorted' => null,
    'align' => 'left',
    'width' => null,
    'size' => null,
])

@php
$classes = Gsmui::classes()
    ->add('font-semibold text-zinc-600 dark:text-zinc-400')
    ->add(match ($size) {
        'sm' => 'px-3 py-2 text-xs',
        'lg' => 'px-4 py-4 text-sm',
        default => 'px-4 py-3 text-sm',
    })
    ->add(match ($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    })
    ->add($sortable ? 'cursor-pointer select-none hover:text-zinc-800 dark:hover:text-zinc-200' : '')
    ;
@endphp

<th {{ $attributes->class($classes) }} @if ($width) style="width: {{ $width }}" @endif data-gsmui-table-th scope="col">
    @if ($sortable)
        <span class="inline-flex items-center gap-1">
            {{ $slot }}
            <span class="inline-flex flex-col text-[8px] leading-none -space-y-0.5 text-zinc-300 dark:text-zinc-600">
                <span class="{{ $sorted === 'asc' ? 'text-zinc-700 dark:text-zinc-300' : '' }}">▲</span>
                <span class="{{ $sorted === 'desc' ? 'text-zinc-700 dark:text-zinc-300' : '' }}">▼</span>
            </span>
        </span>
    @else
        {{ $slot }}
    @endif
</th>
