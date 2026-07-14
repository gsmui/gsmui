@blaze(fold: true)

@props([
    'name' => null,
    'logo' => null,
    'alt' => null,
    'href' => '/',
])

@php
$renderedLogo = $slot?->logo ?? false;
$hasLogo = $renderedLogo !== false || $logo;
@endphp

<a href="{{ $href }}" {{ $attributes->class('inline-flex items-center gap-2.5 transition-opacity hover:opacity-80') }} data-gsmui-brand>
    @if ($hasLogo)
        @if ($renderedLogo)
            <div {{ $slot->logo->attributes->class('size-8 shrink-0 flex items-center justify-center rounded-lg bg-blue-600 text-white text-sm font-bold') }}>
                {{ $renderedLogo }}
            </div>
        @else
            <img class="size-8 shrink-0" src="{{ $logo }}" alt="{{ $alt ?? $name ?? '' }}" />
        @endif
    @endif

    @if ($name)
        <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $name }}</span>
    @endif
</a>
