@props([
    'title' => __('Everything you need'),
    'plan' => ['name' => __('Pro'), 'price' => '$29', 'period' => '/mo', 'desc' => __('The complete toolkit for modern teams. Everything in one plan.'), 'features' => [__('Unlimited projects'), __('25 team members'), __('100 GB storage'), __('Advanced analytics'), __('Custom domain'), __('Priority support'), __('API access'), __('SSO / SAML')]],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-lg">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="relative rounded-2xl border-2 border-zinc-900 dark:border-white p-10 text-center shadow-xl">
            <gsmui:badge class="absolute -top-3 left-1/2 -translate-x-1/2">{{ __('Most popular') }}</gsmui:badge>
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $plan['name'] }}</h3>
            <div class="mt-4 flex items-baseline justify-center gap-1">
                <span class="text-5xl font-bold text-zinc-900 dark:text-white tabular-nums">{{ $plan['price'] }}</span>
                <span class="text-zinc-500 dark:text-zinc-400">{{ $plan['period'] }}</span>
            </div>
            <p class="mt-3 text-sm text-zinc-500 dark:text-zinc-400">{{ $plan['desc'] }}</p>
            <gsmui:button class="mt-8 w-full">{{ __('Get started') }}</gsmui:button>
            <gsmui:divider class="my-8" />
            <ul class="space-y-3 text-left">
                @foreach ($plan['features'] as $feature)
                    <li class="flex items-center gap-3 text-sm text-zinc-600 dark:text-zinc-300">
                        <x-gsmui:icon name="check" class="h-5 w-5 shrink-0 text-green-500" />
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
