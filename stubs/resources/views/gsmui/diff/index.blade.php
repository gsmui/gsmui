@blaze(fold: true, unsafe: ['item1Alt', 'item2Alt'])

@props([
    'src1' => null,
    'src2' => null,
    'item1Alt' => null,
    'item2Alt' => null,
    'aspect' => '16/9',
    'rounded' => true,
    'tabindex' => '0',
])

@php
$aspectClass = match ($aspect) {
    '1/1' => 'aspect-square',
    '4/3' => 'aspect-[4/3]',
    '3/2' => 'aspect-[3/2]',
    '21/9' => 'aspect-[21/9]',
    '9/16' => 'aspect-[9/16]',
    default => 'aspect-[16/9]',
};

$classes = Gsmui::classes()
    ->add('grid grid-cols-1 grid-rows-1 overflow-hidden')
    ->add($aspectClass)
    ->add($rounded ? 'rounded-xl' : '')
    ;

// All three children share the same grid cell to overlap
$cell = 'col-span-1 row-span-1';
@endphp

<figure {{ $attributes->class($classes) }} tabindex="{{ $tabindex }}" data-gsmui-diff>
    {{-- Item 1 (left/front) — resizable by user --}}
    <div class="{{ $cell }} w-1/2 min-w-[3rem] resize-horizontal overflow-hidden z-[2] relative" role="img" tabindex="0" aria-label="{{ $item1Alt ?? 'Before' }}">
        @if ($slot?->item1 ?? false)
            {{ $slot->item1 }}
        @elseif ($src1)
            <img class="w-full h-full object-cover" src="{{ $src1 }}" alt="{{ $item1Alt ?? 'Before' }}" />
        @else
            <div class="w-full h-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400 text-sm">
                Item 1
            </div>
        @endif
    </div>

    {{-- Item 2 (right/back) — full width underneath --}}
    <div class="{{ $cell }} relative" role="img" aria-label="{{ $item2Alt ?? 'After' }}">
        @if ($slot?->item2 ?? false)
            {{ $slot->item2 }}
        @elseif ($src2)
            <img class="w-full h-full object-cover" src="{{ $src2 }}" alt="{{ $item2Alt ?? 'After' }}" />
        @else
            <div class="w-full h-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-400 text-sm">
                Item 2
            </div>
        @endif
    </div>

    {{-- Resizer handle overlay — decorative only, tracks the edge of item-1 via CSS --}}
    <div class="{{ $cell }} pointer-events-none z-[3] relative" aria-hidden="true">
        <div class="absolute inset-y-0 left-1/2 w-[3px] bg-white dark:bg-zinc-300 shadow-md -translate-x-1/2">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 size-8 rounded-full bg-white dark:bg-zinc-300 shadow-lg flex items-center justify-center text-zinc-600 dark:text-zinc-800">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M9 5L4 12L9 19" />
                    <path d="M15 5L20 12L15 19" />
                </svg>
            </div>
        </div>
    </div>
</figure>
