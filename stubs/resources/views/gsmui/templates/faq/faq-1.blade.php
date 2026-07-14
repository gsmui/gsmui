@props([
    'title' => __('Frequently asked questions'),
    'subtitle' => __('Everything you need to know about the product.'),
    'faqs' => [
        ['q' => __('How does the free trial work?'), 'a' => __('Start your 14-day free trial with full access to all features. No credit card required. At the end, choose a plan or continue with the free tier.')],
        ['q' => __('Can I change plans later?'), 'a' => __('Yes, you can upgrade or downgrade at any time. Changes take effect immediately and we prorate the difference.')],
        ['q' => __('What payment methods do you accept?'), 'a' => __('We accept all major credit cards, PayPal, and bank transfers for annual plans. Enterprise customers can pay by invoice.')],
        ['q' => __('Is there a limit on team members?'), 'a' => __('The Starter plan includes 5 members, Pro includes 25, and Enterprise has no limits. Additional seats can be added to any plan.')],
        ['q' => __('Do you offer refunds?'), 'a' => __('We offer a 30-day money-back guarantee on all plans. If you\'re not satisfied, contact support for a full refund.')],
        ['q' => __('Is my data secure?'), 'a' => __('Absolutely. We\'re SOC 2 Type II certified, use end-to-end encryption, and store data in geo-redundant data centers.')],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }} x-data="{ open: null }">
    <div class="mx-auto max-w-3xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        </div>
        <div class="space-y-2">
            @foreach ($faqs as $i => $faq)
                <div class="border border-zinc-200 dark:border-white/10 rounded-xl overflow-hidden">
                    <button @click="open === {{ $i }} ? open = null : open = {{ $i }}" class="flex w-full items-center justify-between px-6 py-4 text-left">
                        <span class="font-medium text-zinc-900 dark:text-white">{{ $faq['q'] }}</span>
                        <x-gsmui:icon :name="open === $i ? 'minus' : 'plus'" class="h-5 w-5 shrink-0 text-zinc-400" />
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse class="px-6 pb-4">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
