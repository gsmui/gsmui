@props([
    'title' => __('Send us a message'),
    'subtitle' => __('Fill out the form below and we\'ll get back to you within 24 hours.'),
    'socials' => [
        ['icon' => 'at-symbol', 'label' => __('Email'), 'value' => 'hello@example.com'],
        ['icon' => 'globe-alt', 'label' => __('Twitter'), 'value' => '@example'],
        ['icon' => 'code-bracket', 'label' => __('GitHub'), 'value' => 'github.com/example'],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-lg">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-4 text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        </div>
        <div class="rounded-2xl border border-zinc-200 dark:border-white/10 p-8">
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Name') }}</label>
                    <gsmui:input class="mt-1 w-full" placeholder="{{ __('Your name') }}" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Email') }}</label>
                    <gsmui:input type="email" class="mt-1 w-full" placeholder="{{ __('you@example.com') }}" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Message') }}</label>
                    <textarea rows="4" class="mt-1 w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/5 px-3 py-2 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:outline-none" placeholder="{{ __('Your message...') }}"></textarea>
                </div>
                <gsmui:button class="w-full">{{ __('Send message') }}</gsmui:button>
            </div>
        </div>
        <div class="mt-8 flex justify-center gap-8">
            @foreach ($socials as $social)
                <div class="text-center">
                    <x-gsmui:icon :name="$social['icon']" class="mx-auto h-5 w-5 text-zinc-400" />
                    <div class="mt-1 text-xs text-zinc-500">{{ $social['value'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
