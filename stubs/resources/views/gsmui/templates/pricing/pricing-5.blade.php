@props([
    'title' => __('Plans for every team'),
    'plans' => [
        ['name' => __('Starter'), 'price' => '$9', 'period' => '/mo', 'features' => [__('5 users'), __('10 GB storage'), __('Basic analytics')]],
        ['name' => __('Pro'), 'price' => '$29', 'period' => '/mo', 'features' => [__('25 users'), __('100 GB storage'), __('Advanced analytics'), __('Priority support')]],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="grid gap-8 lg:grid-cols-3">
            @foreach ($plans as $plan)
                <div class="rounded-2xl border border-zinc-200 dark:border-white/10 p-8">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $plan['name'] }}</h3>
                    <div class="mt-4 flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-zinc-900 dark:text-white tabular-nums">{{ $plan['price'] }}</span>
                        <span class="text-zinc-500 dark:text-zinc-400">{{ $plan['period'] }}</span>
                    </div>
                    <gsmui:button class="mt-6 w-full" variant="outline">{{ __('Get started') }}</gsmui:button>
                    <ul class="mt-6 space-y-3">
                        @foreach ($plan['features'] as $feature)
                            <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                                <x-gsmui:icon name="check" class="h-4 w-4 shrink-0 text-green-500" />
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
            <div class="rounded-2xl border border-zinc-900 dark:border-white bg-zinc-900 dark:bg-white p-8 text-white dark:text-zinc-900">
                <h3 class="text-lg font-semibold">{{ __('Enterprise') }}</h3>
                <p class="mt-4 text-sm text-white/70 dark:text-zinc-500">{{ __('Need a custom plan? Let\'s talk about your requirements.') }}</p>
                <ul class="mt-6 space-y-3">
                    @foreach ([__('Unlimited everything'), __('Dedicated support'), __('Custom SLA'), __('On-premise option')] as $feature)
                        <li class="flex items-center gap-2 text-sm">
                            <x-gsmui:icon name="check" class="h-4 w-4 shrink-0" />
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
                <gsmui:button class="mt-8 w-full" :variant="'outline'">{{ __('Contact sales') }}</gsmui:button>
            </div>
        </div>
    </div>
</section>
