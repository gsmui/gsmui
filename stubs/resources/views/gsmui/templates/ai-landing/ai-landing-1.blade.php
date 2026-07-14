@props([
    'name' => 'PromptAI',
    'tagline' => 'Ask anything. Get answers instantly.',
    'features' => [
        ['title' => 'Natural Language', 'desc' => 'Ask questions in plain English.'],
        ['title' => 'Multi-modal', 'desc' => 'Text, image, and code understanding.'],
        ['title' => 'Context Aware', 'desc' => 'Remembers conversation history.'],
    ],
    'useCases' => ['Content Writing', 'Code Generation', 'Data Analysis', 'Research'],
    'plans' => [
        ['name' => 'Free', 'price' => '$0', 'desc' => '20 queries/day'],
        ['name' => 'Pro', 'price' => '$20', 'desc' => 'Unlimited queries'],
        ['name' => 'API', 'price' => 'Pay per use', 'desc' => 'For developers'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <gsmui:button size="sm" variant="primary">{{ __('Try Free') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-24 text-center">
        <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500">{{ __('Powered by the latest AI models. Available on web, mobile, and API.') }}</p>
    </section>

    <div class="mx-auto max-w-2xl px-6 mb-24">
        <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-6 shadow-lg">
            <div class="mb-4 flex items-center gap-3 text-sm text-zinc-500">
                <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">U</div>
                <span>{{ __('You') }}</span>
            </div>
            <p class="text-zinc-700 dark:text-zinc-300 mb-4">{{ __('Explain quantum computing in simple terms') }}</p>
            <gsmui:divider />
            <div class="mt-4 flex items-center gap-3 text-sm text-zinc-500">
                <div class="h-8 w-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">AI</div>
                <span>{{ $name }}</span>
            </div>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Quantum computing uses quantum mechanics principles like superposition and entanglement to process information in fundamentally new ways...') }}</p>
        </div>
        <div class="mt-4 flex gap-3">
            <input type="text" placeholder="{{ __('Ask anything...') }}" class="flex-1 rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 px-4 py-3 text-sm outline-none" />
            <gsmui:button variant="primary">{{ __('Send') }}</gsmui:button>
        </div>
    </div>

    <main class="mx-auto max-w-5xl px-6 pb-20">
        <section class="mb-24">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Features') }}</h2>
            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8 text-center">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ __($feature['title']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-6 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Use Cases') }}</h2>
            <div class="flex flex-wrap justify-center gap-3">
                @foreach ($useCases as $case)
                    <gsmui:badge>{{ __($case) }}</gsmui:badge>
                @endforeach
            </div>
        </section>

        <section class="mb-20">
            <h2 class="mb-10 text-center text-3xl font-bold text-zinc-900 dark:text-white">{{ __('Pricing') }}</h2>
            <div class="grid gap-6 sm:grid-cols-3">
                @foreach ($plans as $plan)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8 text-center">
                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ __($plan['name']) }}</h3>
                        <p class="mt-2 text-4xl font-bold text-zinc-900 dark:text-white">{{ $plan['price'] }}</p>
                        <p class="mt-1 text-sm text-zinc-500">{{ $plan['desc'] }}</p>
                        <gsmui:button variant="{{ $loop->iteration === 2 ? 'primary' : 'outline' }}" class="mt-6 w-full">{{ __('Get Started') }}</gsmui:button>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</div>
