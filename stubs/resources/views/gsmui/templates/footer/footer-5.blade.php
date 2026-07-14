@props([
    'logo' => __('Acme'),
    'links' => [
        ['label' => __('Privacy'), 'href' => '#'],
        ['label' => __('Terms'), 'href' => '#'],
        ['label' => __('Contact'), 'href' => '#'],
    ],
])

<footer {{ $attributes->class('border-t border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 py-6 px-6') }}>
    <div class="mx-auto max-w-7xl flex flex-col items-center justify-between gap-4 sm:flex-row">
        <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $logo }}</div>
        <div class="text-sm text-zinc-500">
            &copy; {{ date('Y') }} {{ $logo }}. {{ __('All rights reserved.') }}
        </div>
        <div class="flex gap-4">
            @foreach ($links as $link)
                <a href="{{ $link['href'] }}" class="text-sm text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">{{ $link['label'] }}</a>
            @endforeach
        </div>
    </div>
</footer>
