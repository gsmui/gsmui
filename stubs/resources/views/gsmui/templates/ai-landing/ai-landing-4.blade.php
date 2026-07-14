@props([
    'name' => 'TransformAI',
    'tagline' => 'See the before and after.',
    'comparisons' => [
        ['before_title' => 'Manual Data Entry', 'after_title' => 'AI-Powered Extraction', 'before_desc' => 'Hours spent copying data from documents.', 'after_desc' => 'Instant extraction with 99.5% accuracy.'],
        ['before_title' => 'Generic Responses', 'after_title' => 'Personalized Output', 'before_desc' => 'One-size-fits-all content.', 'after_desc' => 'Tailored responses based on context.'],
    ],
    'useCases' => [
        ['name' => 'Healthcare', 'desc' => 'Medical record analysis and patient triage.'],
        ['name' => 'Finance', 'desc' => 'Document processing and fraud detection.'],
        ['name' => 'Legal', 'desc' => 'Contract review and compliance checking.'],
        ['name' => 'Education', 'desc' => 'Personalized learning and grading.'],
    ],
    'plans' => [
        ['name' => 'Starter', 'price' => '$49/mo', 'features' => ['1,000 operations', '2 models', 'Email support']],
        ['name' => 'Growth', 'price' => '$199/mo', 'features' => ['50,000 operations', 'All models', 'Priority support', 'Custom training']],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <gsmui:button size="sm" variant="primary">{{ __('Start Free') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-24 text-center">
        <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500">{{ __('Transform your workflows with AI that delivers measurable results.') }}</p>
    </section>

    <main class="mx-auto max-w-5xl px-6 pb-20">
        <section class="mb-24 space-y-12">
            @foreach ($comparisons as $comparison)
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="rounded-xl border border-red-200 dark:border-red-900/30 bg-red-50/50 dark:bg-red-950/20 p-8">
                        <gsmui:badge color="red" class="mb-4">{{ __('Before') }}</gsmui:badge>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ __($comparison['before_title']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $comparison['before_desc'] }}</p>
                    </div>
                    <div class="rounded-xl border border-emerald-200 dark:border-emerald-900/30 bg-emerald-50/50 dark:bg-emerald-950/20 p-8">
                        <gsmui:badge color="green" class="mb-4">{{ __('After') }}</gsmui:badge>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ __($comparison['after_title']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $comparison['after_desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="mb-24">
            <h2 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Use Cases') }}</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($useCases as $case)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-6">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ __($case['name']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">{{ $case['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-20">
            <h2 class="mb-10 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Pricing') }}</h2>
            <div class="mx-auto grid max-w-3xl gap-6 sm:grid-cols-2">
                @foreach ($plans as $plan)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ __($plan['name']) }}</h3>
                        <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $plan['price'] }}</p>
                        <ul class="mt-4 space-y-2 text-sm text-zinc-500">
                            @foreach ($plan['features'] as $feature)
                                <li>✓ {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <gsmui:button variant="{{ $loop->iteration === 2 ? 'primary' : 'outline' }}" class="mt-6 w-full">{{ __('Get Started') }}</gsmui:button>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl bg-zinc-900 dark:bg-zinc-800 p-12 text-center text-white">
            <h2 class="text-3xl font-bold">{{ __('Ready to transform?') }}</h2>
            <p class="mt-3 text-zinc-400">{{ __('Start your free trial today.') }}</p>
            <gsmui:button variant="primary" class="mt-6">{{ __('Get Started') }}</gsmui:button>
        </section>
    </main>
</div>
