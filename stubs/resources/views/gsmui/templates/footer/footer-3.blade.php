@props([
    'logo' => __('Acme'),
    'socials' => [
        ['icon' => 'at-symbol', 'label' => __('Twitter')],
        ['icon' => 'globe-alt', 'label' => __('LinkedIn')],
        ['icon' => 'code-bracket', 'label' => __('GitHub')],
        ['icon' => 'play', 'label' => __('YouTube')],
    ],
])

<footer {{ $attributes->class('bg-zinc-950 py-16 px-6') }}>
    <div class="mx-auto max-w-7xl text-center">
        <div class="text-xl font-bold text-white">{{ $logo }}</div>
        <div class="mt-8 flex justify-center gap-6">
            @foreach ($socials as $social)
                <a href="#" class="flex h-12 w-12 items-center justify-center rounded-full border border-white/10 text-zinc-400 transition hover:bg-white/10 hover:text-white" aria-label="{{ $social['label'] }}">
                    <x-gsmui:icon :name="$social['icon']" class="h-6 w-6" />
                </a>
            @endforeach
        </div>
        <div class="mt-10 text-sm text-zinc-500">
            &copy; {{ date('Y') }} {{ $logo }}. {{ __('All rights reserved.') }}
        </div>
    </div>
</footer>
