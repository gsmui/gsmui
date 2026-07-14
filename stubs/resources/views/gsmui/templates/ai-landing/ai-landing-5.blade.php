@props([
    'name' => 'EnterpriseAI',
    'tagline' => 'AI built for the enterprise.',
    'stats' => [
        ['label' => 'Fortune 500 Clients', 'value' => '120+'],
        ['label' => 'API Calls/Day', 'value' => '10B+'],
        ['label' => 'Uptime', 'value' => '99.99%'],
        ['label' => 'Avg Response', 'value' => '45ms'],
    ],
    'security' => [
        'SOC 2 Type II Certified',
        'GDPR Compliant',
        'HIPAA Compliant',
        'ISO 27001',
        'Data Encryption at Rest & Transit',
        'On-premise Deployment Option',
    ],
    'caseStudies' => [
        ['company' => 'Global Bank', 'result' => '60% reduction in manual review time', 'desc' => 'Automated compliance document processing.'],
        ['company' => 'Health System', 'result' => '40% faster patient triage', 'desc' => 'AI-assisted clinical decision support.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <gsmui:button size="sm" variant="primary">{{ __('Contact Sales') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-24 text-center">
        <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500 {{ __('Secure, compliant, and scalable AI solutions for large organizations.') }}">{{ __('Secure, compliant, and scalable AI solutions for large organizations.') }}</p>
        <div class="mt-10 flex justify-center gap-4">
            <gsmui:button variant="primary" size="lg">{{ __('Contact Sales') }}</gsmui:button>
            <gsmui:button variant="outline" size="lg">{{ __('View Documentation') }}</gsmui:button>
        </div>
    </section>

    <section class="border-y border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-900 px-6 py-12">
        <div class="mx-auto grid max-w-4xl grid-cols-2 gap-8 sm:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="text-center">
                    <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                    <p class="mt-1 text-sm text-zinc-500">{{ __($stat['label']) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <main class="mx-auto max-w-6xl px-6 py-20">
        <section class="mb-24">
            <h2 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Security & Compliance') }}</h2>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($security as $item)
                    <div class="flex items-center gap-3 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-4">
                        <span class="text-emerald-500">✓</span>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Case Studies') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ($caseStudies as $study)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8">
                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $study['result'] }}</p>
                        <h3 class="mt-2 text-xl font-bold text-zinc-900 dark:text-white">{{ $study['company'] }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">{{ $study['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl bg-zinc-900 dark:bg-zinc-800 p-12 text-center text-white">
            <h2 class="text-3xl font-bold">{{ __('Ready to deploy AI at scale?') }}</h2>
            <p class="mt-3 text-zinc-400">{{ __('Talk to our enterprise team about your needs.') }}</p>
            <gsmui:button variant="primary" class="mt-6">{{ __('Contact Sales') }}</gsmui:button>
        </section>
    </main>
</div>
