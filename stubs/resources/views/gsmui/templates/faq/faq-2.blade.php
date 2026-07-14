@props([
    'title' => __('Questions & Answers'),
    'faqs' => [
        ['q' => __('How does pricing work?'), 'a' => __('We offer three tiers: Starter ($9/mo), Pro ($29/mo), and Enterprise ($99/mo). Annual billing saves 20%. All plans include a 14-day free trial.')],
        ['q' => __('Can I integrate with existing tools?'), 'a' => __('Yes, we support 500+ integrations including Slack, GitHub, Jira, and more. Our API and webhooks let you build custom integrations too.')],
        ['q' => __('What about data privacy?'), 'a' => __('We\'re GDPR compliant and SOC 2 certified. Your data is encrypted at rest and in transit. We never sell or share your data with third parties.')],
        ['q' => __('Do you offer migration support?'), 'a' => __('Yes, our team provides free migration assistance for Pro and Enterprise plans. We handle the entire process to ensure zero downtime.')],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="space-y-8">
            @foreach ($faqs as $faq)
                <div class="grid gap-6 border-b border-zinc-200 dark:border-white/10 pb-8 md:grid-cols-2">
                    <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $faq['q'] }}</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $faq['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
