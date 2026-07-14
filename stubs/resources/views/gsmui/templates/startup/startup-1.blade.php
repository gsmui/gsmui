@props([
    'title' => __('Build Faster, Ship Smarter'),
    'subtitle' => __('The all-in-one platform that helps teams go from idea to production in record time.'),
    'features' => [
        ['icon' => 'rocket-launch', 'name' => 'Instant Deploy', 'desc' => 'Push code and go live in seconds with zero-downtime deployments.'],
        ['icon' => 'chart-bar', 'name' => 'Real-Time Analytics', 'desc' => 'Monitor performance and user behavior with live dashboards.'],
        ['icon' => 'shield-check', 'name' => 'Enterprise Security', 'desc' => 'SOC 2 compliant with end-to-end encryption and SSO support.'],
        ['icon' => 'users', 'name' => 'Team Collaboration', 'desc' => 'Built-in tools for code review, commenting, and project management.'],
        ['icon' => 'cog-6-tooth', 'name' => 'Custom Workflows', 'desc' => 'Automate repetitive tasks with configurable pipelines.'],
        ['icon' => 'globe', 'name' => 'Global CDN', 'desc' => 'Deliver content at the edge with 200+ points of presence worldwide.'],
    ],
    'pricing' => [
        'free' => ['name' => 'Starter', 'price' => '$0', 'period' => '/month', 'features' => ['3 projects', '1 GB storage', 'Community support', 'Basic analytics']],
        'pro' => ['name' => 'Pro', 'price' => '$29', 'period' => '/month', 'features' => ['Unlimited projects', '50 GB storage', 'Priority support', 'Advanced analytics', 'Custom domains']],
        'enterprise' => ['name' => 'Enterprise', 'price' => '$99', 'period' => '/month', 'features' => ['Everything in Pro', 'Unlimited storage', 'Dedicated support', 'SSO & SAML', 'Custom contracts', 'SLA guarantee']],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="border-b border-zinc-200 dark:border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="Launchpad" href="/" />
            <nav class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Features') }}</a>
                <a href="#pricing" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Pricing') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm">{{ __('Sign Up') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-4xl px-6 py-32 text-center">
        <gsmui:heading size="xl" level="1">
            <span class="bg-gradient-to-r from-indigo-600 to-violet-600 dark:from-indigo-400 dark:to-violet-400 bg-clip-text text-transparent">{{ $title }}</span>
        </gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-5 max-w-2xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-10 flex justify-center gap-4">
            <gsmui:button variant="primary" size="default" class="bg-indigo-600 hover:bg-indigo-700 border-indigo-600">{{ __('Get Started Free') }}</gsmui:button>
            <gsmui:button variant="outline" size="default">{{ __('View Demo') }}</gsmui:button>
        </div>
    </section>

    <section id="features" class="bg-zinc-50 dark:bg-white/5 py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="text-center mb-16">
                <gsmui:heading size="lg" level="2">{{ __('Everything You Need') }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mt-3">{{ __('Powerful features to accelerate your development workflow.') }}</gsmui:text>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($features as $feature)
                    <div class="p-6 rounded-xl bg-white dark:bg-zinc-800/50 border border-zinc-200 dark:border-white/5">
                        <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-indigo-100 dark:bg-indigo-500/10 mb-4">
                            <gsmui:icon name="{{ $feature['icon'] }}" class="text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <gsmui:heading size="default" level="3">{{ $feature['name'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" size="sm" class="mt-2">{{ $feature['desc'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="pricing" class="mx-auto max-w-7xl px-6 py-24">
        <div class="text-center mb-16">
            <gsmui:heading size="lg" level="2">{{ __('Simple, Transparent Pricing') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mt-3">{{ __('No hidden fees. Cancel anytime.') }}</gsmui:text>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach ($pricing as $key => $plan)
                <gsmui:card variant="{{ $key === 'pro' ? 'elevated' : 'outlined' }}" size="lg" class="{{ $key === 'pro' ? 'ring-2 ring-indigo-500 dark:ring-indigo-400' : '' }}">
                    <div class="p-8">
                        @if ($key === 'pro')
                            <gsmui:badge color="indigo" variant="solid" rounded>{{ __('Most Popular') }}</gsmui:badge>
                        @endif
                        <gsmui:heading size="default" level="3" class="mt-3">{{ $plan['name'] }}</gsmui:heading>
                        <div class="mt-4 flex items-baseline gap-1">
                            <gsmui:heading size="lg" level="2">{{ $plan['price'] }}</gsmui:heading>
                            <gsmui:text variant="subtle" size="sm">{{ $plan['period'] }}</gsmui:text>
                        </div>
                        <ul class="mt-6 space-y-3">
                            @foreach ($plan['features'] as $feat)
                                <li class="flex items-center gap-2">
                                    <gsmui:icon name="check" variant="mini" class="text-indigo-500" />
                                    <gsmui:text size="sm">{{ $feat }}</gsmui:text>
                                </li>
                            @endforeach
                        </ul>
                        <gsmui:button variant="{{ $key === 'pro' ? 'primary' : 'outline' }}" size="default" class="mt-8 w-full {{ $key === 'pro' ? 'bg-indigo-600 hover:bg-indigo-700 border-indigo-600' : '' }}">{{ __('Choose :plan', ['plan' => $plan['name']]) }}</gsmui:button>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-gradient-to-r from-indigo-600 to-violet-600 py-20 text-center">
        <gsmui:heading size="lg" level="2" class="text-white">{{ __('Ready to Launch?') }}</gsmui:heading>
        <gsmui:text size="default" class="mt-3 text-indigo-100">{{ __('Start building for free today.') }}</gsmui:text>
        <gsmui:button variant="outline" size="default" class="mt-8 border-white text-white hover:bg-white/10">{{ __('Get Started') }}</gsmui:button>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-12">
        <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <gsmui:brand name="Launchpad" href="/" />
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} Launchpad. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
