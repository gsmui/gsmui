@props([
    'title' => __('Choose your billing'),
    'subtitle' => __('Save 20% with annual billing.'),
    'plans' => [
        ['name' => __('Starter'), 'monthly' => '$9', 'annual' => '$7', 'desc' => __('For individuals.'), 'features' => [__('5 users'), __('10 GB storage'), __('Basic analytics'), __('Email support')]],
        ['name' => __('Pro'), 'monthly' => '$29', 'annual' => '$23', 'desc' => __('For growing teams.'), 'features' => [__('25 users'), __('100 GB storage'), __('Advanced analytics'), __('Priority support'), __('Custom domain')]],
        ['name' => __('Enterprise'), 'monthly' => '$99', 'annual' => '$79', 'desc' => __('For organizations.'), 'features' => [__('Unlimited users'), __('1 TB storage'), __('Custom reports'), __('Dedicated support'), __('SSO'), __('SLA')]],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }} x-data="{ annual: true }">
    <div class="mx-auto max-w-5xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        </div>
        <div class="flex items-center justify-center gap-3 mb-12">
            <span class="text-sm" :class="!annual ? 'font-semibold text-zinc-900 dark:text-white' : 'text-zinc-500'">{{ __('Monthly') }}</span>
            <button @click="annual = !annual" class="relative h-6 w-11 rounded-full bg-zinc-200 dark:bg-white/10 transition-colors" :class="annual && 'bg-zinc-900 dark:bg-white'">
                <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white dark:bg-zinc-900 shadow transition-transform" :class="annual && 'translate-x-5'"></span>
            </button>
            <span class="text-sm" :class="annual ? 'font-semibold text-zinc-900 dark:text-white' : 'text-zinc-500'">{{ __('Annual') }}</span>
        </div>
        <div class="grid gap-8 lg:grid-cols-3">
            @foreach ($plans as $plan)
                <div class="rounded-2xl border border-zinc-200 dark:border-white/10 p-8">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $plan['name'] }}</h3>
                    <div class="mt-4 flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-zinc-900 dark:text-white tabular-nums" x-text="annual ? '{{ $plan['annual'] }}' : '{{ $plan['monthly'] }}'"></span>
                        <span class="text-zinc-500 dark:text-zinc-400">/mo</span>
                    </div>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $plan['desc'] }}</p>
                    <gsmui:button class="mt-6 w-full" variant="outline">{{ __('Get started') }}</gsmui:button>
                    <ul class="mt-8 space-y-3">
                        @foreach ($plan['features'] as $feature)
                            <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                                <x-gsmui:icon name="check" class="h-4 w-4 shrink-0 text-green-500" />
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>
