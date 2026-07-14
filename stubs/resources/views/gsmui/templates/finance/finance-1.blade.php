@props([
    'title' => 'NovaBank',
    'subtitle' => __('Banking made simple. Manage your money from anywhere, anytime.'),
    'features' => [],
    'accounts' => [],
    'stats' => [],
])

@php
$features = count($features) ? $features : [
    ['icon' => 'shield-check', 'name' => 'Secure Banking', 'desc' => 'Bank-grade encryption protects every transaction.'],
    ['icon' => 'device-phone-mobile', 'name' => 'Mobile First', 'desc' => 'Full banking capabilities from your phone.'],
    ['icon' => 'currency-dollar', 'name' => 'No Hidden Fees', 'desc' => 'Transparent pricing with zero surprise charges.'],
    ['icon' => 'globe', 'name' => 'Global Transfers', 'desc' => 'Send money worldwide with low, flat fees.'],
    ['icon' => 'chart-bar', 'name' => 'Smart Analytics', 'desc' => 'Track spending patterns with visual insights.'],
    ['icon' => 'clock', 'name' => 'Instant Payments', 'desc' => 'Real-time transfers to anyone, anywhere.'],
];
$accounts = count($accounts) ? $accounts : [
    ['name' => 'Checking Account', 'balance' => '$12,450.00', 'change' => '+$2,340 this month'],
    ['name' => 'Savings Account', 'balance' => '$48,200.50', 'change' => '+1.2% APY'],
    ['name' => 'Investment Portfolio', 'balance' => '$23,100.75', 'change' => '+8.4% YTD'],
];
$stats = count($stats) ? $stats : [
    ['value' => '2M+', 'label' => 'Active Users'],
    ['value' => '$15B', 'label' => 'Transactions'],
    ['value' => '99.9%', 'label' => 'Uptime'],
    ['value' => '4.9', 'label' => 'App Rating'],
];
@endphp

<div {{ $attributes->class('bg-white dark:bg-zinc-900 min-h-screen') }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Products') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Business') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Personal') }}</a>
            </nav>
            <div class="flex items-center gap-3">
                <gsmui:button variant="ghost" size="sm">{{ __('Login') }}</gsmui:button>
                <gsmui:button variant="primary" size="sm">{{ __('Sign Up') }}</gsmui:button>
            </div>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <gsmui:heading size="xl" level="1">{{ __('Banking Made Simple') }}</gsmui:heading>
                <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">{{ $subtitle }}</p>
                <div class="mt-8 flex items-center gap-4">
                    <gsmui:button variant="primary" href="#">{{ __('Get Started') }}</gsmui:button>
                    <gsmui:button variant="outline" href="#">{{ __('Learn More') }}</gsmui:button>
                </div>
            </div>
            <div class="bg-gradient-to-br from-teal-100 to-blue-100 dark:from-teal-900/30 dark:to-blue-900/30 rounded-2xl h-64 lg:h-80 flex items-center justify-center">
                <gsmui:icon name="credit-card" class="w-24 h-24 text-teal-400 dark:text-teal-500" />
            </div>
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($stats as $stat)
                    <div class="text-center">
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white tabular-nums">{{ $stat['value'] }}</p>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <gsmui:heading size="lg" level="2">{{ __('Why Choose :title', ['title' => $title]) }}</gsmui:heading>
        </div>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($features as $feature)
                <gsmui:card>
                    <div class="p-2 w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center mb-3">
                        <gsmui:icon :name="$feature['icon']" class="w-5 h-5 text-teal-600 dark:text-teal-400" />
                    </div>
                    <gsmui:text variant="strong">{{ $feature['name'] }}</gsmui:text>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $feature['desc'] }}</p>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2">{{ __('Your Accounts') }}</gsmui:heading>
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($accounts as $account)
                    <gsmui:card>
                        <gsmui:text variant="subtle" size="sm">{{ $account['name'] }}</gsmui:text>
                        <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-white tabular-nums">{{ $account['balance'] }}</p>
                        <p class="mt-1 text-xs text-emerald-600 dark:text-emerald-400">{{ $account['change'] }}</p>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
