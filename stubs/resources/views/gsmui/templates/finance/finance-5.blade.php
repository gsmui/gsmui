@props([
    'title' => 'LedgerPro',
    'subtitle' => __('Accounting made easy. Focus on your business, we handle the numbers.'),
    'services' => [],
    'pricing' => [],
])

@php
$services = count($services) ? $services : [
    ['icon' => 'document', 'name' => 'Bookkeeping', 'desc' => 'Automated transaction tracking and reconciliation.'],
    ['icon' => 'chart-pie', 'name' => 'Financial Reports', 'desc' => 'Real-time P&L, balance sheets, and cash flow statements.'],
    ['icon' => 'banknotes', 'name' => 'Tax Preparation', 'desc' => 'Year-round tax planning and filing assistance.'],
    ['icon' => 'credit-card', 'name' => 'Invoicing', 'desc' => 'Professional invoices with automatic payment reminders.'],
    ['icon' => 'users', 'name' => 'Payroll', 'desc' => 'Streamlined payroll processing and tax compliance.'],
    ['icon' => 'chart-bar', 'name' => 'Budgeting', 'desc' => 'Smart budget tools with variance analysis.'],
];
$pricing = count($pricing) ? $pricing : [
    ['name' => 'Starter', 'price' => '$29', 'period' => '/mo', 'features' => ['50 transactions/mo', 'Basic reports', 'Invoicing', 'Email support']],
    ['name' => 'Professional', 'price' => '$79', 'period' => '/mo', 'features' => ['Unlimited transactions', 'Advanced reports', 'Tax prep', 'Priority support', 'Payroll (5 employees)']],
    ['name' => 'Enterprise', 'price' => '$199', 'period' => '/mo', 'features' => ['Everything in Pro', 'Multi-entity', 'Custom integrations', 'Dedicated accountant', 'Unlimited payroll']],
];
@endphp

<div {{ $attributes->class('bg-white dark:bg-zinc-900 min-h-screen') }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Services') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Pricing') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Resources') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm">{{ __('Get Started') }}</gsmui:button>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <gsmui:heading size="xl" level="1">{{ __('Accounting Made Easy') }}</gsmui:heading>
        <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">{{ $subtitle }}</p>
        <div class="mt-8 flex items-center justify-center gap-4">
            <gsmui:button variant="primary" href="#">{{ __('Start Free Trial') }}</gsmui:button>
            <gsmui:button variant="outline" href="#">{{ __('Watch Demo') }}</gsmui:button>
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <gsmui:heading size="lg" level="2">{{ __('Our Services') }}</gsmui:heading>
            </div>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <gsmui:card>
                        <div class="p-2 w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-3">
                            <gsmui:icon :name="$service['icon']" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <gsmui:text variant="strong">{{ $service['name'] }}</gsmui:text>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $service['desc'] }}</p>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <gsmui:heading size="lg" level="2">{{ __('Simple, Transparent Pricing') }}</gsmui:heading>
        </div>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($pricing as $tier)
                <gsmui:card @class([
                    'relative',
                    'ring-2 ring-blue-500 dark:ring-blue-400' => $loop->iteration === 2,
                ])>
                    @if($loop->iteration === 2)
                        <gsmui:badge color="blue" class="absolute -top-3 left-1/2 -translate-x-1/2">{{ __('Most Popular') }}</gsmui:badge>
                    @endif
                    <gsmui:text variant="strong">{{ $tier['name'] }}</gsmui:text>
                    <div class="mt-2 flex items-baseline gap-1">
                        <span class="text-3xl font-bold text-zinc-900 dark:text-white tabular-nums">{{ $tier['price'] }}</span>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $tier['period'] }}</span>
                    </div>
                    <gsmui:divider />
                    <ul class="space-y-2">
                        @foreach($tier['features'] as $feature)
                            <li class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <gsmui:icon name="check" class="w-4 h-4 text-blue-500" />
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    <gsmui:button :variant="$loop->iteration === 2 ? 'primary' : 'outline'" size="sm" class="mt-4 w-full" href="#">
                        {{ __('Choose :name', ['name' => $tier['name']]) }}
                    </gsmui:button>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-12 text-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:icon name="star" class="w-8 h-8 text-amber-400 mx-auto" variant="solid" />
            <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400 italic">"{{ __('LedgerPro transformed how we manage our finances. We save 10+ hours every month.') }}"</p>
            <p class="mt-3 text-sm font-medium text-zinc-900 dark:text-white">— {{ __('Tom Richards, CEO at BuildCo') }}</p>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
