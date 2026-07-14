@blaze(fold: true)

@props([
    'sortable' => false,
    'sorted' => false,
])

@php
$classes = Gsmui::classes()
    ->add('px-4 py-3 text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400')
    ->add($sortable ? 'cursor-pointer select-none hover:text-zinc-700 dark:hover:text-zinc-200' : '')
    ;
@endphp

<th
    {{ $attributes->class($classes) }}
    scope="col"
    @if ($sortable)
        x-on:click="$dispatch('table:sort', { key: '{{ $attributes->get('key') }}' })"
        role="columnheader"
        aria-sort="{{ $sorted ? 'ascending' : 'none' }}"
    @endif
>
    <div class="flex items-center gap-1">
        {{ $slot }}
        @if ($sortable)
            <span class="inline-flex flex-col gap-0.5 opacity-50">
                <gsmui:icon.chevron-up variant="micro" x-show="$dispatch('table:sort')?.detail?.direction === 'asc' && $dispatch('table:sort')?.detail?.key === '{{ $attributes->get('key') }}'" x-cloak />
                <gsmui:icon.chevron-down variant="micro" x-show="$dispatch('table:sort')?.detail?.direction === 'desc' && $dispatch('table:sort')?.detail?.key === '{{ $attributes->get('key') }}'" x-cloak />
            </span>
        @endif
    </div>
</th>
