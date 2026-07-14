@props([
    'name' => 'DarkMetrics',
    'tagline' => 'Analytics that actually make sense.',
    'tabs' => ['Dashboard', 'Reports', 'Alerts'],
    'integrations' => ['Slack', 'GitHub', 'Jira', 'Figma', 'Notion', 'Linear'],
    'plans' => [
        ['name' => 'Starter', 'price' => '$9', 'features' => ['5 dashboards', '7-day retention', 'Email support']],
        ['name' => 'Growth', 'price' => '$29', 'features' => ['Unlimited dashboards', '90-day retention', 'Priority support', 'API access']],
        ['name' => 'Scale', 'price' => '$79', 'features' => ['Everything in Growth', '1-year retention', 'SSO', 'Custom integrations']],
    ],
    'faqs' => [
        ['q' => 'Can I try before buying?', 'a' => 'Yes, all plans come with a 14-day free trial.'],
        ['q' => 'What happens to my data if I cancel?', 'a' => 'You can export everything before your plan ends.'],
        ['q' => 'Do you offer annual billing?', 'a' => 'Yes, annual billing saves 20%.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 text-white') }}>
    <header class="sticky top-0 z-50 border-b border-white/10 bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" class="text-white" />
            <div class="flex items-center gap-4">
                <span class="text-sm text-zinc-400 cursor-pointer">{{ __('Login') }}</span>
                <gsmui:button size="sm" variant="primary">{{ __('Start Free Trial') }}</gsmui:button>
            </div>
        </div>
    </header>

    <section class="px-6 pt-24 pb-12 text-center">
        <h1 class="text-5xl font-bold tracking-tight">{{ $tagline }}</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-400">{{ __('Beautiful dashboards, real-time alerts, and deep insights — all in a dark-themed interface that\'s easy on the eyes.') }}</p>
        <gsmui:button variant="primary" size="lg" class="mt-8">{{ __('Start Free Trial') }}</gsmui:button>
    </section>

    <div class="mx-auto max-w-4xl px-6 mb-24">
        <div class="rounded-2xl border border-white/10 bg-zinc-900 p-4">
            <div class="flex gap-2 mb-4">
                @foreach ($tabs as $tab)
                    <span class="rounded-md px-3 py-1.5 text-xs {{ $loop->first ? 'bg-white/10 text-white' : 'text-zinc-500' }}">{{ __($tab) }}</span>
                @endforeach
            </div>
            <div class="aspect-[16/9] rounded-lg bg-zinc-800"></div>
        </div>
    </div>

    <main class="mx-auto max-w-6xl px-6 pb-20">
        <section class="mb-24">
            <h2 class="mb-8 text-center text-2xl font-bold">{{ __('Integrates with your stack') }}</h2>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach ($integrations as $integration)
                    <div class="rounded-lg border border-white/10 bg-white/5 px-6 py-3 text-sm">{{ $integration }}</div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-10 text-center text-2xl font-bold">{{ __('Pricing') }}</h2>
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($plans as $plan)
                    <div class="rounded-xl border {{ $loop->iteration === 2 ? 'border-blue-500 shadow-lg shadow-blue-500/10' : 'border-white/10' }} bg-zinc-900 p-8">
                        <h3 class="font-semibold">{{ __($plan['name']) }}</h3>
                        <p class="mt-2 text-4xl font-bold">{{ $plan['price'] }}<span class="text-base font-normal text-zinc-500">/mo</span></p>
                        <ul class="mt-6 space-y-2 text-sm text-zinc-400">
                            @foreach ($plan['features'] as $feature)
                                <li>✓ {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <gsmui:button variant="{{ $loop->iteration === 2 ? 'primary' : 'outline' }}" class="mt-8 w-full border-white/20 {{ $loop->iteration !== 2 ? 'text-white hover:bg-white/10' : '' }}">{{ __('Get Started') }}</gsmui:button>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-20">
            <h2 class="mb-8 text-center text-2xl font-bold">{{ __('FAQ') }}</h2>
            <div class="mx-auto max-w-2xl space-y-4">
                @foreach ($faqs as $faq)
                    <div class="rounded-lg border border-white/10 p-5">
                        <p class="font-semibold">{{ __($faq['q']) }}</p>
                        <p class="mt-2 text-sm text-zinc-400">{{ $faq['a'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 py-8 text-center text-sm text-zinc-600">
        &copy; {{ date('Y') }} {{ $name }}.
    </footer>
</div>
