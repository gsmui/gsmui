@props([
    'title' => 'SafeGuard',
    'subtitle' => __('Protect what matters most with comprehensive, affordable coverage.'),
    'products' => [],
    'testimonials' => [],
])

@php
$products = count($products) ? $products : [
    ['icon' => 'shield-check', 'name' => 'Life Insurance', 'desc' => 'Financial security for your loved ones, no matter what happens.', 'starting_price' => '$12/mo'],
    ['icon' => 'building-office', 'name' => 'Home Insurance', 'desc' => 'Protect your home and belongings from unexpected events.', 'starting_price' => '$25/mo'],
    ['icon' => 'device-phone-mobile', 'name' => 'Auto Insurance', 'desc' => 'Comprehensive coverage for your vehicle with roadside assistance.', 'starting_price' => '$35/mo'],
    ['icon' => 'heart', 'name' => 'Health Insurance', 'desc' => 'Quality healthcare coverage with a wide network of providers.', 'starting_price' => '$89/mo'],
];
$testimonials = count($testimonials) ? $testimonials : [
    ['quote' => 'SafeGuard made the claims process incredibly easy. They handled everything within 48 hours.', 'author' => 'Maria Garcia'],
    ['quote' => 'Best rates I found after comparing 10+ providers. The online quote tool is fantastic.', 'author' => 'James Wilson'],
    ['quote' => 'Their customer service team is outstanding. Always available and genuinely helpful.', 'author' => 'Aisha Patel'],
];
@endphp

<div {{ $attributes->class('bg-white dark:bg-zinc-900 min-h-screen') }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Products') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Claims') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('About') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm">{{ __('Get a Quote') }}</gsmui:button>
        </div>
    </header>

    <section class="bg-gradient-to-b from-blue-50 to-white dark:from-blue-950/30 dark:to-zinc-900 py-20 text-center">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="xl" level="1">{{ __('Protect What Matters') }}</gsmui:heading>
            <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">{{ $subtitle }}</p>
            <div class="mt-8 flex items-center justify-center gap-4">
                <gsmui:button variant="primary" size="default" href="#">{{ __('Get a Free Quote') }}</gsmui:button>
                <gsmui:button variant="outline" size="default" href="#">{{ __('Compare Plans') }}</gsmui:button>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <gsmui:heading size="lg" level="2">{{ __('Insurance Products') }}</gsmui:heading>
        </div>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <gsmui:card class="text-center">
                    <div class="mx-auto p-3 w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <gsmui:icon :name="$product['icon']" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                    </div>
                    <gsmui:text variant="strong" class="mt-3">{{ $product['name'] }}</gsmui:text>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $product['desc'] }}</p>
                    <gsmui:divider />
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Starting at') }}</p>
                    <p class="text-xl font-bold text-blue-600 dark:text-blue-400 tabular-nums">{{ $product['starting_price'] }}</p>
                    <gsmui:button variant="outline" size="sm" class="mt-3 w-full" href="#">{{ __('Learn More') }}</gsmui:button>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <gsmui:heading size="lg" level="2">{{ __('Why Choose :title', ['title' => $title]) }}</gsmui:heading>
            </div>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach([
                    ['icon' => 'clock', 'title' => 'Fast Claims', 'desc' => 'Most claims processed within 48 hours.'],
                    ['icon' => 'currency-dollar', 'title' => 'Best Rates', 'desc' => 'Competitive pricing with no hidden fees.'],
                    ['icon' => 'users', 'title' => '24/7 Support', 'desc' => 'Always here when you need us most.'],
                ] as $item)
                    <div class="flex items-start gap-4">
                        <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30 shrink-0">
                            <gsmui:icon :name="$item['icon']" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <gsmui:text variant="strong">{{ $item['title'] }}</gsmui:text>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <gsmui:heading size="lg" level="2">{{ __('What Our Customers Say') }}</gsmui:heading>
        </div>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
                <gsmui:card>
                    <gsmui:icon name="star" class="w-5 h-5 text-amber-400" variant="solid" />
                    <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400 italic">"{{ $testimonial['quote'] }}"</p>
                    <p class="mt-3 text-sm font-medium text-zinc-900 dark:text-white">— {{ $testimonial['author'] }}</p>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-blue-600 py-16 text-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <gsmui:heading size="lg" level="2" class="text-white">{{ __('Get Protected Today') }}</gsmui:heading>
            <p class="mt-2 text-blue-100">{{ __('Get a free, no-obligation quote in under 2 minutes.') }}</p>
            <gsmui:button variant="filled" class="mt-6" href="#">{{ __('Get Your Quote') }}</gsmui:button>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
