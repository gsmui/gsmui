@props([
    'logo' => __('Acme'),
    'socials' => [
        ['icon' => 'at-symbol', 'label' => __('Twitter')],
        ['icon' => 'globe-alt', 'label' => __('LinkedIn')],
        ['icon' => 'code-bracket', 'label' => __('GitHub')],
    ],
])

<footer {{ $attributes->class('border-t border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 py-12 px-6') }}>
    <div class="mx-auto max-w-7xl text-center">
        <div class="text-lg font-bold text-zinc-900 dark:text-white">{{ $logo }}</div>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Subscribe to our newsletter for the latest updates.') }}</p>
        <div class="mx-auto mt-6 flex max-w-sm gap-2">
            <input type="email" placeholder="{{ __('Enter your email') }}" class="flex-1 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/5 px-4 py-2 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:outline-none" />
            <gsmui:button>{{ __('Subscribe') }}</gsmui:button>
        </div>
        <div class="mt-6 flex justify-center gap-4">
            @foreach ($socials as $social)
                <a href="#" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300" aria-label="{{ $social['label'] }}">
                    <x-gsmui:icon :name="$social['icon']" class="h-5 w-5" />
                </a>
            @endforeach
        </div>
        <div class="mt-8 text-xs text-zinc-400">
            &copy; {{ date('Y') }} {{ $logo }}. {{ __('All rights reserved.') }}
        </div>
    </div>
</footer>
