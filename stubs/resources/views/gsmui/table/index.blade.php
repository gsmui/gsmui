@blaze(fold: true)

@props([
    'sortable' => false,
    ' striped' => true,
])

@php
$classes = Gsmui::classes()
    ->add('w-full overflow-hidden rounded-xl border border-zinc-200 dark:border-white/10')
    ->add('bg-white dark:bg-zinc-800')
    ;
@endphp

<div
    {{ $attributes->class($classes) }}
    data-gsmui-table
>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                {{ $header }}
            </thead>
            <tbody
                x-data="{
                    sortKey: '',
                    sortDir: 'asc',
                    sort(key) {
                        if (!{{ $sortable ? 'true' : 'false' }}) return;
                        this.sortDir = this.sortKey === key ? (this.sortDir === 'asc' ? 'desc' : 'asc') : 'asc';
                        this.sortKey = key;
                        $dispatch('table:sort', { key, direction: this.sortDir });
                    },
                }"
            >
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
