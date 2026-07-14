@props([
    'links' => null,
])

@php
$defaultLinks = [
    ['label' => 'Terms', 'href' => '#'],
    ['label' => 'Privacy', 'href' => '#'],
    ['label' => 'Help', 'href' => '#'],
];

$items = $links ?? $defaultLinks;
@endphp

<div {{ $attributes->class('mt-8 text-center text-sm text-zinc-500 dark:text-zinc-400') }}>
    <nav class="flex items-center justify-center gap-4">
        @foreach ($items as $link)
            <a href="{{ $link['href'] }}" class="hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">{{ $link['label'] }}</a>
            @if (! $loop->last)
                <span class="text-zinc-300 dark:text-zinc-600">&middot;</span>
            @endif
        @endforeach
    </nav>
</div>
