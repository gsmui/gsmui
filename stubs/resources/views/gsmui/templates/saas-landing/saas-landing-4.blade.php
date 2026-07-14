@props([
    'name' => 'TeamBoard',
    'tagline' => 'The project management tool that gets out of your way.',
    'comparison' => [
        ['feature' => 'Unlimited projects', 'us' => true, 'them' => false],
        ['feature' => 'Real-time collaboration', 'us' => true, 'them' => true],
        ['feature' => 'Built-in time tracking', 'us' => true, 'them' => false],
        ['feature' => 'Custom workflows', 'us' => true, 'them' => true],
        ['feature' => 'API access', 'us' => true, 'them' => false],
        ['feature' => 'AI task prioritization', 'us' => true, 'them' => false],
    ],
    'plans' => [
        ['name' => 'Free', 'price_monthly' => '$0', 'price_annual' => '$0', 'features' => ['3 projects', '5 users', 'Basic features']],
        ['name' => 'Pro', 'price_monthly' => '$15', 'price_annual' => '$12', 'features' => ['Unlimited projects', 'Unlimited users', 'Advanced features', 'Priority support']],
    ],
    'testimonials' => [
        ['quote' => 'Switched from Competitor X and never looked back.', 'author' => 'Anna P., Product Manager'],
        ['quote' => 'Finally, a tool that\'s both powerful and simple.', 'author' => 'Chris W., CTO'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <gsmui:button size="sm" variant="primary">{{ __('Try Free') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-24 text-center">
        <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500">{{ __('See how we stack up against the competition.') }}</p>
        <gsmui:button variant="primary" size="lg" class="mt-8">{{ __('Start Free Trial') }}</gsmui:button>
    </section>

    <main class="mx-auto max-w-5xl px-6 pb-20">
        <section class="mb-24">
            <h2 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Feature Comparison') }}</h2>
            <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-white/10">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-900">
                            <th class="p-4 text-left font-semibold text-zinc-900 dark:text-white">{{ __('Feature') }}</th>
                            <th class="p-4 text-center font-semibold text-blue-600 dark:text-blue-400">{{ $name }}</th>
                            <th class="p-4 text-center font-semibold text-zinc-500">{{ __('Competitor') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparison as $row)
                            <tr class="border-b border-zinc-100 dark:border-white/5">
                                <td class="p-4 text-zinc-700 dark:text-zinc-300">{{ $row['feature'] }}</td>
                                <td class="p-4 text-center text-emerald-500">{{ $row['us'] ? '✓' : '—' }}</td>
                                <td class="p-4 text-center text-zinc-400">{{ $row['them'] ? '✓' : '✗' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-4 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Pricing') }}</h2>
            <p class="mb-8 text-center text-sm text-zinc-500">{{ __('Toggle monthly/annual (save 20%)') }}</p>
            <div class="mx-auto grid max-w-2xl gap-6 sm:grid-cols-2">
                @foreach ($plans as $plan)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ __($plan['name']) }}</h3>
                        <p class="mt-2 text-4xl font-bold text-zinc-900 dark:text-white">{{ $plan['price_monthly'] }}<span class="text-base font-normal text-zinc-500">/mo</span></p>
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

        <section class="mb-20">
            <h2 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Testimonials') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ($testimonials as $testimonial)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-6">
                        <p class="text-zinc-600 dark:text-zinc-400 italic">"{{ $testimonial['quote'] }}"</p>
                        <p class="mt-3 text-sm font-semibold text-zinc-900 dark:text-white">{{ $testimonial['author'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</div>
