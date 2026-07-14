@props([
    'title' => 'WealthGrow',
    'subtitle' => __('Grow your wealth with smart, data-driven investment strategies.'),
    'portfolio' => [],
    'features' => [],
])

@php
$portfolio = count($portfolio) ? $portfolio : [
    ['name' => 'S&P 500 Index Fund', 'value' => '$34,250.00', 'change' => '+12.4%'],
    ['name' => 'Tech Growth ETF', 'value' => '$18,720.50', 'change' => '+24.8%'],
    ['name' => 'Bond Portfolio', 'value' => '$12,500.00', 'change' => '+3.2%'],
    ['name' => 'Real Estate Fund', 'value' => '$8,900.75', 'change' => '+6.7%'],
];
$features = count($features) ? $features : [
    ['icon' => 'chart-bar', 'name' => 'Advanced Analytics', 'desc' => 'Real-time portfolio tracking with detailed performance metrics.'],
    ['icon' => 'shield-check', 'name' => 'Bank-Grade Security', 'desc' => 'Your investments are protected with institutional-level security.'],
    ['icon' => 'light-bulb', 'name' => 'Smart Insights', 'desc' => 'AI-powered recommendations tailored to your risk profile.'],
    ['icon' => 'currency-dollar', 'name' => 'Low Fees', 'desc' => 'Competitive pricing that keeps more money in your pocket.'],
    ['icon' => 'globe', 'name' => 'Global Markets', 'desc' => 'Access 50+ markets worldwide from a single platform.'],
    ['icon' => 'sparkles', 'name' => 'Auto Rebalancing', 'desc' => 'Set it and forget it — we keep your portfolio on track.'],
];
@endphp

<div {{ $attributes->class('bg-zinc-900 text-white min-h-screen') }}>
    <header class="border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Invest') }}</a>
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Portfolio') }}</a>
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Research') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm">{{ __('Start Investing') }}</gsmui:button>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-2xl">
            <gsmui:heading size="xl" level="1">{{ __('Grow Your Wealth') }}</gsmui:heading>
            <p class="mt-4 text-lg text-zinc-400">{{ $subtitle }}</p>
            <div class="mt-8">
                <div class="bg-zinc-800 rounded-xl p-6 border border-zinc-700">
                    <p class="text-sm text-zinc-400">{{ __('Total Portfolio Value') }}</p>
                    <p class="mt-1 text-4xl font-bold tabular-nums text-emerald-400">$74,371.25</p>
                    <p class="mt-1 text-sm text-emerald-400 flex items-center gap-1">
                        <gsmui:icon name="arrow-trending-up" class="w-4 h-4" /> {{ __('+$8,240.50 (12.5%) this year') }}
                    </p>
                </div>
            </div>
            <div class="mt-8 flex items-center gap-4">
                <gsmui:button variant="filled" href="#">{{ __('Create Portfolio') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#">{{ __('View Demo') }}</gsmui:button>
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2">{{ __('Your Holdings') }}</gsmui:heading>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($portfolio as $holding)
                    <gsmui:card variant="flat">
                        <gsmui:text variant="subtle" size="sm">{{ $holding['name'] }}</gsmui:text>
                        <p class="mt-1 text-xl font-bold tabular-nums text-white">{{ $holding['value'] }}</p>
                        <p class="mt-1 text-sm text-emerald-400 flex items-center gap-1">
                            <gsmui:icon name="arrow-trending-up" class="w-3.5 h-3.5" /> {{ $holding['change'] }}
                        </p>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-800 rounded-xl h-48 lg:h-64 flex items-center justify-center border border-zinc-700">
                <div class="text-center">
                    <gsmui:icon name="chart-bar" class="w-12 h-12 text-zinc-600 mx-auto" />
                    <p class="mt-2 text-sm text-zinc-500">{{ __('Performance chart') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2">{{ __('Why Choose :title', ['title' => $title]) }}</gsmui:heading>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($features as $feature)
                    <gsmui:card variant="flat">
                        <div class="p-2 w-10 h-10 rounded-lg bg-emerald-900/30 flex items-center justify-center mb-3">
                            <gsmui:icon :name="$feature['icon']" class="w-5 h-5 text-emerald-400" />
                        </div>
                        <gsmui:text variant="strong">{{ $feature['name'] }}</gsmui:text>
                        <p class="mt-1 text-sm text-zinc-400">{{ $feature['desc'] }}</p>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-zinc-800 py-16 text-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2">{{ __('Start Building Wealth Today') }}</gsmui:heading>
            <p class="mt-2 text-zinc-400">{{ __('Join thousands of investors who trust :title with their financial future.', ['title' => $title]) }}</p>
            <gsmui:button variant="filled" class="mt-6" href="#">{{ __('Open Free Account') }}</gsmui:button>
        </div>
    </section>

    <footer class="border-t border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
