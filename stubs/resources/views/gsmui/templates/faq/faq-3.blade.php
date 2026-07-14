@props([
    'title' => __('Help Center'),
    'categories' => [
        ['label' => __('General'), 'faqs' => [
            ['q' => __('What is your product?'), 'a' => __('An all-in-one platform for teams to collaborate, automate workflows, and ship faster.')],
            ['q' => __('Who is it for?'), 'a' => __('Teams of all sizes — from startups to enterprises — that want to streamline their development process.')],
        ]],
        ['label' => __('Billing'), 'faqs' => [
            ['q' => __('How does billing work?'), 'a' => __('We bill monthly or annually. Annual plans save 20%. All major credit cards and PayPal accepted.')],
            ['q' => __('Can I get a refund?'), 'a' => __('Yes, we offer a 30-day money-back guarantee on all plans. Contact support for a full refund.')],
        ]],
        ['label' => __('Technical'), 'faqs' => [
            ['q' => __('Do you have an API?'), 'a' => __('Yes, our RESTful API is available on all plans. GraphQL API is available on Pro and Enterprise.')],
            ['q' => __('What about uptime?'), 'a' => __('We guarantee 99.99% uptime with our Enterprise SLA. Check our status page for real-time updates.')],
        ]],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }} x-data="{ active: 0, open: null }">
    <div class="mx-auto max-w-3xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="flex justify-center gap-2 mb-8">
            @foreach ($categories as $i => $cat)
                <button @click="active = {{ $i }}; open = null" :class="active === {{ $i }} ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-zinc-100 dark:bg-white/10 text-zinc-600 dark:text-zinc-400'" class="rounded-lg px-4 py-2 text-sm font-medium transition-colors">{{ $cat['label'] }}</button>
            @endforeach
        </div>
        @foreach ($categories as $i => $cat)
            <div x-show="active === {{ $i }}" class="space-y-2">
                @foreach ($cat['faqs'] as $j => $faq)
                    <div class="border border-zinc-200 dark:border-white/10 rounded-xl overflow-hidden">
                        <button @click="open === {{ $j }} ? open = null : open = {{ $j }}" class="flex w-full items-center justify-between px-6 py-4 text-left">
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $faq['q'] }}</span>
                            <x-gsmui:icon :name="open === $j ? 'minus' : 'plus'" class="h-5 w-5 shrink-0 text-zinc-400" />
                        </button>
                        <div x-show="open === {{ $j }}" x-collapse class="px-6 pb-4">
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
