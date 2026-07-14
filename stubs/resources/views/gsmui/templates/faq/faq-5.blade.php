@props([
    'title' => __('Common questions'),
    'faqs' => [
        ['q' => __('What\'s included in the free plan?'), 'a' => __('Up to 3 users, 5 GB storage, basic analytics, and community support. Perfect for small teams getting started.')],
        ['q' => __('How do I cancel my subscription?'), 'a' => __('Go to Settings > Billing > Cancel Plan. Your access continues until the end of the billing period. No questions asked.')],
        ['q' => __('Do you offer discounts for nonprofits?'), 'a' => __('Yes, we offer 50% off all plans for qualified nonprofits and educational institutions. Contact us with your organization details.')],
        ['q' => __('Can I use my own domain?'), 'a' => __('Custom domains are available on Pro and Enterprise plans. We handle SSL certificates and DNS configuration automatically.')],
        ['q' => __('Where is my data stored?'), 'a' => __('Data is stored in AWS data centers in the US and EU. Enterprise customers can choose their preferred region.')],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-3xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="space-y-0">
            @foreach ($faqs as $faq)
                <div class="border-b border-zinc-200 dark:border-white/10 py-6">
                    <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $faq['q'] }}</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $faq['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
