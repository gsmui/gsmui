@props([
    'title' => __('FAQ'),
    'faqs' => [
        ['q' => __('How do I get started?'), 'a' => __('Sign up for a free trial, create your workspace, and invite your team. The onboarding wizard guides you through the rest.')],
        ['q' => __('What platforms do you support?'), 'a' => __('Web, iOS, Android, and desktop apps for macOS, Windows, and Linux. Plus browser extensions for Chrome, Firefox, and Safari.')],
        ['q' => __('Is there a free plan?'), 'a' => __('Yes! Our free tier includes up to 3 users, 5 GB storage, and basic features. Upgrade anytime for more power.')],
        ['q' => __('How does support work?'), 'a' => __('Starter plans get email support. Pro plans get priority support with 4-hour response times. Enterprise gets a dedicated account manager.')],
        ['q' => __('Can I export my data?'), 'a' => __('Yes, you can export all your data at any time in CSV, JSON, or XML format. No vendor lock-in.')],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }} x-data="{ search: '', faqs: {{ json_encode($faqs) }} }" x-init="$watch('search', val => $el.querySelectorAll('[data-faq]').forEach(el => el.style.display = el.dataset.faq.toLowerCase().includes(val.toLowerCase()) ? '' : 'none'))">
    <div class="mx-auto max-w-3xl">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="relative mb-8">
            <x-gsmui:icon name="magnifying-glass" class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-zinc-400" />
            <input x-model="search" type="text" placeholder="{{ __('Search questions...') }}" class="w-full rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/5 py-3 pl-12 pr-4 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 focus:outline-none" />
        </div>
        <div class="space-y-2" x-data="{ open: null }">
            @foreach ($faqs as $i => $faq)
                <div data-faq="{{ $faq['q'] }} {{ $faq['a'] }}" class="border border-zinc-200 dark:border-white/10 rounded-xl overflow-hidden">
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
