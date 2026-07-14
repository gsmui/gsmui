@blaze(fold: true)

@props([
    'variant' => 'default',
    'columns' => null,
    'copyright' => null,
    'brand' => null,
    'logo' => null,
    'logoAlt' => null,
    'description' => null,
    'divided' => false,
    'compact' => false,
])

@php
$variantClasses = match ($variant) {
    'minimal' => 'py-6 border-t border-zinc-200 dark:border-zinc-800',
    'dark' => 'bg-zinc-900 text-zinc-300 border-t border-zinc-800',
    'bordered' => 'border-t-2 border-zinc-200 dark:border-zinc-700 py-12',
    'centered' => 'text-center py-10 border-t border-zinc-200 dark:border-zinc-800',
    'divided' => 'py-12 border-t border-zinc-200 dark:border-zinc-800 [&>div]:divide-y [&>div]:divide-zinc-100 dark:[&>div]:divide-zinc-800',
    default => 'py-10 sm:py-12 border-t border-zinc-200 dark:border-zinc-800',
};

$containerClasses = Gsmui::classes()
    ->add('mx-auto px-4 sm:px-6')
    ->add($compact ? 'max-w-5xl' : 'max-w-7xl')
    ;

$gridClasses = Gsmui::classes()
    ->add('grid gap-8 sm:gap-12')
    ->add(match ((int) ($columns ?? 4)) {
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 sm:grid-cols-2',
        3 => 'grid-cols-1 sm:grid-cols-3',
        default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
    })
    ;

$copyrightClasses = Gsmui::classes()
    ->add('text-sm')
    ->add($variant === 'dark' ? 'text-zinc-400' : 'text-zinc-500 dark:text-zinc-400')
    ;

$brandTextClasses = Gsmui::classes()
    ->add('text-lg font-bold')
    ->add($variant === 'dark' ? 'text-white' : 'text-zinc-900 dark:text-white')
    ;

$descClasses = Gsmui::classes()
    ->add('mt-3 text-sm leading-relaxed')
    ->add($variant === 'dark' ? 'text-zinc-400' : 'text-zinc-500 dark:text-zinc-400')
    ;

$logoClasses = 'size-8 rounded-lg';

$socialClasses = Gsmui::classes()
    ->add('flex items-center gap-3 mt-4')
    ->add($variant === 'centered' ? 'justify-center' : '')
    ;

$bottomClasses = Gsmui::classes()
    ->add('mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-zinc-200 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-4')
    ;
@endphp

<footer {{ $attributes->class($variantClasses) }} data-gsmui-layout-footer>
    <div class="{{ $containerClasses }}">
        <div class="{{ $gridClasses }}">
            {{-- Brand column (always first) --}}
            @if ($logo || $brand || $description || ($slot?->brand ?? false) || ($slot?->description ?? false))
                <div class="{{ $variant === 'centered' ? 'col-span-full text-center' : 'sm:col-span-2 lg:col-span-1' }}" data-gsmui-footer-brand>
                    @if ($logo || ($slot?->logo ?? false))
                        @if ($slot?->logo ?? false)
                            <div class="{{ $logoClasses }} mb-3">{{ $slot->logo }}</div>
                        @else
                            <img class="{{ $logoClasses }} mb-3" src="{{ $logo }}" alt="{{ $logoAlt ?? $brand ?? '' }}" />
                        @endif
                    @endif

                    @if ($brand)
                        <div class="{{ $brandTextClasses }}">{{ $brand }}</div>
                    @endif

                    @if ($description)
                        <p class="{{ $descClasses }}">{{ $description }}</p>
                    @elseif ($slot?->description ?? false)
                        <p class="{{ $descClasses }}">{{ $slot->description }}</p>
                    @endif

                    {{-- Social links --}}
                    @if ($slot?->social ?? false)
                        <div class="{{ $socialClasses }}">
                            {{ $slot->social }}
                        </div>
                    @endif
                </div>
            @endif

            {{-- Named columns --}}
            @foreach (['one', 'two', 'three'] as $colKey)
                @php
                    $colSlot = $slot->{$colKey} ?? false;
                @endphp
                @if ($colSlot)
                    <div data-gsmui-footer-column="{{ $colKey }}">
                        {{ $colSlot }}
                    </div>
                @endif
            @endforeach

            {{-- Default slot fills remaining space when no named columns --}}
            @unless ($slot?->one ?? $slot?->two ?? $slot?->three ?? false)
                {{ $slot }}
            @endunless
        </div>

        {{-- Bottom bar with copyright --}}
        @if ($copyright || ($slot?->bottom ?? false))
            <div class="{{ $bottomClasses }}">
                @if ($copyright)
                    <p class="{{ $copyrightClasses }}">&copy; {{ date('Y') }} {{ $copyright }}</p>
                @elseif ($slot?->bottom ?? false)
                    <div class="{{ $variant === 'dark' ? 'text-zinc-400' : 'text-zinc-500 dark:text-zinc-400' }}">
                        {{ $slot->bottom }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</footer>
