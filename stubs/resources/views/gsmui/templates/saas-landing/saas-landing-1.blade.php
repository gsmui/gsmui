@props([
    'name' => 'CloudSync',
    'tagline' => 'Sync your team\'s work in one place.',
    'features' => [
        ['icon' => '🔄', 'title' => 'Real-time Sync', 'desc' => 'Changes propagate instantly across all devices.'],
        ['icon' => '📊', 'title' => 'Advanced Analytics', 'desc' => 'Deep insights into your team\'s productivity.'],
        ['icon' => '🔗', 'title' => 'Integrations', 'desc' => 'Connect with 150+ tools you already use.'],
    ],
    'steps' => [
        ['number' => '1', 'title' => 'Sign Up', 'desc' => 'Create your free account in seconds.'],
        ['number' => '2', 'title' => 'Connect Tools', 'desc' => 'Link your existing workflow tools.'],
        ['number' => '3', 'title' => 'Start Syncing', 'desc' => 'See everything come together.'],
    ],
    'plans' => [
        ['name' => 'Free', 'price' => '$0', 'features' => ['5 users', '1 GB storage', 'Basic sync']],
        ['name' => 'Pro', 'price' => '$12', 'features' => ['50 users', '100 GB', 'Priority sync', 'Analytics']],
        ['name' => 'Enterprise', 'price' => '$49', 'features' => ['Unlimited', '1 TB', 'SSO', 'SLA', 'Dedicated support']],
    ],
    'testimonials' => [
        ['quote' => 'CloudSync eliminated our tool sprawl overnight.', 'author' => 'Sarah K., VP Operations'],
        ['quote' => 'Our team productivity increased by 35%.', 'author' => 'Tom R., Engineering Manager'],
        ['quote' => 'The best investment we made this year.', 'author' => 'Lisa M., CEO'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <div class="flex items-center gap-4">
                <span class="text-sm text-zinc-500 cursor-pointer">{{ __('Login') }}</span>
                <gsmui:button size="sm" variant="primary">{{ __('Get Started Free') }}</gsmui:button>
            </div>
        </div>
    </header>

    <section class="px-6 py-24 text-center">
        <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500">{{ __('The all-in-one platform that brings your team, tools, and data together.') }}</p>
        <div class="mt-8 flex justify-center gap-4">
            <gsmui:button variant="primary" size="lg">{{ __('Start Free Trial') }}</gsmui:button>
            <gsmui:button variant="outline" size="lg">{{ __('See Demo') }}</gsmui:button>
        </div>
    </section>

    <main class="mx-auto max-w-6xl px-6 pb-20">
        <section class="mb-24">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Features') }}</h2>
            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8 text-center">
                        <span class="text-4xl">{{ $feature['icon'] }}</span>
                        <h3 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-white">{{ __($feature['title']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('How It Works') }}</h2>
            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($steps as $step)
                    <div class="text-center">
                        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-xl font-bold text-blue-600 dark:text-blue-400">{{ $step['number'] }}</div>
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ __($step['title']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Pricing') }}</h2>
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($plans as $plan)
                    <div class="rounded-xl border {{ $loop->iteration === 2 ? 'border-blue-500 shadow-lg shadow-blue-500/10 dark:border-blue-400' : 'border-zinc-200 dark:border-white/10' }} bg-white dark:bg-zinc-900 p-8">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ __($plan['name']) }}</h3>
                        <p class="mt-2 text-4xl font-bold text-zinc-900 dark:text-white">{{ $plan['price'] }}<span class="text-base font-normal text-zinc-500">/mo</span></p>
                        <ul class="mt-6 space-y-2 text-sm text-zinc-500">
                            @foreach ($plan['features'] as $feature)
                                <li>✓ {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <gsmui:button variant="{{ $loop->iteration === 2 ? 'primary' : 'outline' }}" class="mt-8 w-full">{{ __('Choose Plan') }}</gsmui:button>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('What People Say') }}</h2>
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($testimonials as $testimonial)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-6">
                        <p class="text-zinc-600 dark:text-zinc-400 italic">"{{ $testimonial['quote'] }}"</p>
                        <p class="mt-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ $testimonial['author'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl bg-blue-600 p-12 text-center text-white">
            <h2 class="text-3xl font-bold">{{ __('Ready to get started?') }}</h2>
            <p class="mt-3 text-blue-100">{{ __('Join 10,000+ teams already using CloudSync.') }}</p>
            <gsmui:button class="mt-6 bg-white text-blue-600 hover:bg-zinc-100">{{ __('Start Free Trial') }}</gsmui:button>
        </section>
    </main>
</div>
