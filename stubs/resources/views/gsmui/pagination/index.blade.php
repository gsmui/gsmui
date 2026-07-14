@blaze(fold: true)

@props([
    'current' => 1,
    'last' => 1,
    'show' => 5,
    'size' => null,
    'simple' => false,
    'previousLabel' => null,
    'nextLabel' => null,
    'firstLabel' => null,
    'lastLabel' => null,
])

@php
$classes = Gsmui::classes()
    ->add('flex items-center gap-1')
    ->add(match ($size) {
        'sm' => 'text-xs',
        'lg' => 'text-base',
        default => 'text-sm',
    })
    ;

$btnBase = Gsmui::classes()
    ->add('inline-flex items-center justify-center font-medium rounded-lg border transition-colors duration-150')
    ->add('border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300')
    ->add('hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-600')
    ->add(match ($size) {
        'sm' => 'h-7 min-w-7 px-1.5 text-xs',
        'lg' => 'h-10 min-w-10 px-3 text-sm',
        default => 'h-8 min-w-8 px-2 text-xs',
    })
    ;

$btnActive = Gsmui::classes()
    ->add('inline-flex items-center justify-center font-medium rounded-lg')
    ->add('bg-blue-600 text-white border-blue-600')
    ->add(match ($size) {
        'sm' => 'h-7 min-w-7 px-1.5 text-xs',
        'lg' => 'h-10 min-w-10 px-3 text-sm',
        default => 'h-8 min-w-8 px-2 text-xs',
    })
    ;

$btnDisabled = Gsmui::classes()
    ->add('opacity-40 cursor-not-allowed pointer-events-none')
    ;

$btnEllipsis = Gsmui::classes()
    ->add('inline-flex items-center justify-center text-zinc-400 dark:text-zinc-500 select-none')
    ->add(match ($size) {
        'sm' => 'h-7 min-w-7 text-xs',
        'lg' => 'h-10 min-w-10 text-sm',
        default => 'h-8 min-w-8 text-xs',
    })
    ;

// Build page range
$current = max(1, min((int) $current, (int) $last));
$last = max(1, (int) $last);
$show = max(3, (int) $show);

$half = floor(($show - 1) / 2);
$start = max(1, $current - $half);
$end = min($last, $start + $show - 1);
$start = max(1, $end - $show + 1);

$pages = [];
if ($start > 1) $pages[] = 'first';
if ($start > 2) $pages[] = 'dots-l';
for ($i = $start; $i <= $end; $i++) $pages[] = $i;
if ($end < $last - 1) $pages[] = 'dots-r';
if ($end < $last) $pages[] = 'last';

$prevDisabled = $current <= 1;
$nextDisabled = $current >= $last;

$previousLabel = $previousLabel ?? __('Previous');
$nextLabel = $nextLabel ?? __('Next');
$firstLabel = $firstLabel ?? '1';
$lastLabel = $lastLabel ?? (string) $last;
@endphp

<nav {{ $attributes->class('flex items-center gap-1') }} data-gsmui-pagination aria-label="Pagination">
    {{-- Previous button --}}
    <button
        class="{{ $btnBase }} {{ $prevDisabled ? $btnDisabled : '' }}"
        @if (!$prevDisabled) wire:click="gotoPage({{ $current - 1 }})" wire:loading.attr="disabled" @endif
        @if ($prevDisabled) disabled @endif
        aria-label="{{ $previousLabel }}"
        rel="prev"
    >
        <gsmui:icon name="chevron-left" variant="mini" class="size-4" />
        <span class="hidden sm:inline ms-1">{{ $previousLabel }}</span>
    </button>

    {{-- Page buttons --}}
    @if (!$simple)
        @foreach ($pages as $page)
            @if ($page === 'first')
                <button class="{{ $btnBase }}" wire:click="gotoPage(1)" wire:loading.attr="disabled" aria-label="{{ __('Page 1') }}">
                    {{ $firstLabel }}
                </button>
            @elseif ($page === 'last')
                <button class="{{ $btnBase }}" wire:click="gotoPage({{ $last }})" wire:loading.attr="disabled" aria-label="{{ __('Page :page', ['page' => $last]) }}">
                    {{ $lastLabel }}
                </button>
            @elseif ($page === 'dots-l' || $page === 'dots-r')
                <span class="{{ $btnEllipsis }}" aria-hidden="true">&hellip;</span>
            @elseif ($page == $current)
                <span class="{{ $btnActive }}" aria-current="page">{{ $page }}</span>
            @else
                <button class="{{ $btnBase }}" wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" aria-label="{{ __('Page :page', ['page' => $page]) }}">
                    {{ $page }}
                </button>
            @endif
        @endforeach
    @endif

    {{-- Next button --}}
    <button
        class="{{ $btnBase }} {{ $nextDisabled ? $btnDisabled : '' }}"
        @if (!$nextDisabled) wire:click="gotoPage({{ $current + 1 }})" wire:loading.attr="disabled" @endif
        @if ($nextDisabled) disabled @endif
        aria-label="{{ $nextLabel }}"
        rel="next"
    >
        <span class="hidden sm:inline me-1">{{ $nextLabel }}</span>
        <gsmui:icon name="chevron-right" variant="mini" class="size-4" />
    </button>
</nav>
