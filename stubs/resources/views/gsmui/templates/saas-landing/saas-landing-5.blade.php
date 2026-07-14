@props([
    'name' => 'TrustScale',
    'tagline' => 'Trusted by 10,000+ teams worldwide.',
    'logos' => ['Stripe', 'Vercel', 'Linear', 'Notion', 'Figma', 'GitHub'],
    'caseStudies' => [
        ['company' => 'TechCorp', 'result' => '3x faster deployment', 'desc' => 'How TechCorp modernized their CI/CD with TrustScale.'],
        ['company' => 'FinanceHub', 'result' => '$2M saved annually', 'desc' => 'FinanceHub reduced infrastructure costs by 40%.'],
    ],
    'testimonials' => [
        ['quote' => 'Game-changing platform for our engineering team.', 'author' => 'Emily R., CTO at GrowthCo'],
        ['quote' => 'The ROI was visible within the first month.', 'author' => 'Michael S., VP Engineering'],
        ['quote' => 'Best tool we\'ve adopted in 2024.', 'author' => 'Sarah L., Head of DevOps'],
    ],
    'plans' => [
        ['name' => 'Team', 'price' => '$19', 'desc' => 'For small teams'],
        ['name' => 'Business', 'price' => '$49', 'desc' => 'For growing companies'],
        ['name' => 'Enterprise', 'price' => 'Custom', 'desc' => 'For large organizations'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <gsmui:button size="sm" variant="primary">{{ __('Get Started') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-24 text-center">
        <gsmui:badge color="green" class="mb-6">{{ __('10,000+ teams') }}</gsmui:badge>
        <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500">{{ __('The platform engineering tool that scales with your team.') }}</p>
        <gsmui:button variant="primary" size="lg" class="mt-8">{{ __('Start Free Trial') }}</gsmui:button>
    </section>

    <section class="border-y border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-900 px-6 py-10">
        <p class="mb-6 text-center text-xs font-semibold uppercase tracking-widest text-zinc-400">{{ __('Trusted by leading companies') }}</p>
        <div class="mx-auto flex max-w-3xl flex-wrap items-center justify-center gap-8">
            @foreach ($logos as $logo)
                <span class="text-lg font-bold text-zinc-300 dark:text-zinc-600">{{ $logo }}</span>
            @endforeach
        </div>
    </section>

    <main class="mx-auto max-w-6xl px-6 py-20">
        <section class="mb-24">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Case Studies') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ($caseStudies as $study)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8">
                        <p class="text-sm text-blue-600 dark:text-blue-400 font-semibold">{{ $study['result'] }}</p>
                        <h3 class="mt-2 text-xl font-bold text-zinc-900 dark:text-white">{{ $study['company'] }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">{{ $study['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('What teams are saying') }}</h2>
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($testimonials as $testimonial)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-6">
                        <p class="text-zinc-600 dark:text-zinc-400 italic">"{{ $testimonial['quote'] }}"</p>
                        <p class="mt-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ $testimonial['author'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-20">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Pricing') }}</h2>
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($plans as $plan)
                    <div class="rounded-xl border {{ $loop->iteration === 2 ? 'border-blue-500 shadow-lg shadow-blue-500/10 dark:border-blue-400' : 'border-zinc-200 dark:border-white/10' }} bg-white dark:bg-zinc-900 p-8 text-center">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ __($plan['name']) }}</h3>
                        <p class="mt-2 text-4xl font-bold text-zinc-900 dark:text-white">{{ $plan['price'] }}{{ $plan['price'] !== 'Custom' ? '/mo' : '' }}</p>
                        <p class="mt-1 text-sm text-zinc-500">{{ $plan['desc'] }}</p>
                        <gsmui:button variant="{{ $loop->iteration === 2 ? 'primary' : 'outline' }}" class="mt-6 w-full">{{ __('Get Started') }}</gsmui:button>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl bg-blue-600 p-12 text-center text-white">
            <h2 class="text-3xl font-bold">{{ __('Join 10,000+ teams') }}</h2>
            <p class="mt-3 text-blue-100">{{ __('Start your free trial today. No credit card required.') }}</p>
            <gsmui:button class="mt-6 bg-white text-blue-600 hover:bg-zinc-100">{{ __('Start Free Trial') }}</gsmui:button>
        </section>
    </main>
</div>
