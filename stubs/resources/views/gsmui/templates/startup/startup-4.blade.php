@props([
    'title' => __('Redefining Enterprise Workflow Automation'),
    'subtitle' => __('We help Fortune 500 companies eliminate manual processes and unlock operational efficiency.'),
    'metrics' => [
        ['value' => '$4.2M', 'label' => __('ARR'), 'change' => '+180%'],
        ['value' => '12K+', 'label' => __('Active Users'), 'change' => '+95%'],
        ['value' => '340', 'label' => __('Enterprise Clients'), 'change' => '+62%'],
        ['value' => '99.9%', 'label' => __('Uptime'), 'change' => __('Stable')],
    ],
    'traction' => [
        ['date' => 'Q1 2025', 'milestone' => __('Seed round closed — $2.5M from top-tier angels.')],
        ['date' => 'Q2 2025', 'milestone' => __('Product launch. 500 users in first 30 days.')],
        ['date' => 'Q4 2025', 'milestone' => __('First enterprise contract with Fortune 500 company.')],
        ['date' => 'Q1 2026', 'milestone' => __('Series A — $12M led by Sequoia Capital.')],
        ['date' => 'Q2 2026', 'milestone' => __('Crossed 10K users. Expanded to EMEA market.')],
    ],
    'team' => [
        ['name' => 'Catherine Lee', 'role' => 'CEO — Ex-McKinsey, Stanford MBA'],
        ['name' => 'Raj Patel', 'role' => 'CTO — Ex-Google, 15yr infra experience'],
        ['name' => 'Emma Davis', 'role' => 'VP Sales — Built $50M pipeline at Salesforce'],
        ['name' => 'Tom Nguyen', 'role' => 'VP Product — Ex-Stripe PM Lead'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="border-b border-zinc-200 dark:border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="FlowScale" href="/" />
            <gsmui:button variant="outline" size="sm">{{ __('Investor Login') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-7xl px-6 py-24">
        <div class="max-w-3xl">
            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <gsmui:text variant="subtle" size="lg" class="mt-4">{{ $subtitle }}</gsmui:text>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16">
            @foreach ($metrics as $metric)
                <gsmui:card variant="outlined" size="sm">
                    <div class="p-5">
                        <gsmui:heading size="lg" level="2" class="text-slate-900 dark:text-white">{{ $metric['value'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" size="sm" class="mt-1">{{ $metric['label'] }}</gsmui:text>
                        <gsmui:badge color="green" variant="solid" rounded class="mt-3">{{ $metric['change'] }}</gsmui:badge>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <gsmui:divider />

    <section class="mx-auto max-w-7xl px-6 py-24">
        <gsmui:heading size="lg" level="2">{{ __('Traction & Milestones') }}</gsmui:heading>
        <div class="mt-12 space-y-0">
            @foreach ($traction as $item)
                <div class="flex gap-6 py-6 border-b border-zinc-100 dark:border-white/5 last:border-0">
                    <gsmui:badge color="slate" variant="solid" rounded class="shrink-0 h-fit">{{ $item['date'] }}</gsmui:badge>
                    <gsmui:text size="default" class="font-medium">{{ $item['milestone'] }}</gsmui:text>
                </div>
            @endforeach
        </div>
    </section>

    <gsmui:divider />

    <section class="mx-auto max-w-7xl px-6 py-24">
        <gsmui:heading size="lg" level="2">{{ __('Leadership Team') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-3">{{ __('Seasoned operators with deep domain expertise.') }}</gsmui:text>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-12">
            @foreach ($team as $member)
                <div class="flex items-start gap-4">
                    <gsmui:avatar name="{{ $member['name'] }}" size="lg" circle />
                    <div>
                        <gsmui:text variant="strong" size="sm">{{ $member['name'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm">{{ $member['role'] }}</gsmui:text>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-slate-900 dark:bg-slate-800 py-20 text-center">
        <gsmui:heading size="lg" level="2" class="text-white">{{ __('Interested in Learning More?') }}</gsmui:heading>
        <gsmui:text size="default" class="mt-3 text-slate-300">{{ __('Request our full pitch deck and financials.') }}</gsmui:text>
        <gsmui:button variant="outline" size="default" class="mt-8 border-white text-white hover:bg-white/10">{{ __('Learn More') }}</gsmui:button>
    </section>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-12">
        <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <gsmui:brand name="FlowScale" href="/" />
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} FlowScale Inc. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
