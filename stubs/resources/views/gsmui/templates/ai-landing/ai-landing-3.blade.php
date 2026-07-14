@props([
    'name' => 'ChatFlow',
    'tagline' => 'Your AI assistant for everything.',
    'messages' => [
        ['role' => 'user', 'text' => 'Write a product description for a wireless headphone.'],
        ['role' => 'ai', 'text' => 'Experience unparalleled freedom with our premium wireless headphones. Featuring 40mm drivers, active noise cancellation, and 30-hour battery life...'],
    ],
    'integrations' => ['Slack', 'Teams', 'Discord', 'Notion', 'Google Docs', 'Zapier'],
    'plans' => [
        ['name' => 'Personal', 'price' => '$0', 'desc' => 'For individuals'],
        ['name' => 'Team', 'price' => '$15/user', 'desc' => 'For teams of 5+'],
        ['name' => 'Enterprise', 'price' => 'Custom', 'desc' => 'For organizations'],
    ],
    'faqs' => [
        ['q' => 'Is my data used for training?', 'a' => 'No. We never use customer data to train our models.'],
        ['q' => 'What models do you support?', 'a' => 'GPT-4, Claude, Gemini, and our proprietary models.'],
        ['q' => 'Can I use it offline?', 'a' => 'The mobile app supports limited offline functionality.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" />
            <gsmui:button size="sm" variant="primary">{{ __('Try Free') }}</gsmui:button>
        </div>
    </header>

    <section class="px-6 py-20">
        <div class="mx-auto max-w-5xl text-center">
            <h1 class="text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
            <p class="mx-auto mt-4 max-w-xl text-lg text-zinc-500">{{ __('Ask questions, generate content, analyze data, and automate tasks.') }}</p>
        </div>
    </section>

    <div class="mx-auto max-w-2xl px-6 mb-24">
        <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 shadow-lg overflow-hidden">
            <div class="border-b border-zinc-200 dark:border-white/10 px-4 py-3 flex items-center gap-2">
                <div class="h-3 w-3 rounded-full bg-red-400"></div>
                <div class="h-3 w-3 rounded-full bg-yellow-400"></div>
                <div class="h-3 w-3 rounded-full bg-green-400"></div>
                <span class="ml-2 text-xs text-zinc-400">{{ $name }}</span>
            </div>
            <div class="p-6 space-y-4">
                @foreach ($messages as $msg)
                    <div class="flex gap-3 {{ $msg['role'] === 'user' ? 'justify-end' : '' }}">
                        @if ($msg['role'] === 'ai')
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-xs font-bold text-emerald-600">AI</div>
                        @endif
                        <div class="max-w-[80%] rounded-xl px-4 py-3 text-sm {{ $msg['role'] === 'user' ? 'bg-blue-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300' }}">
                            {{ $msg['text'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <main class="mx-auto max-w-5xl px-6 pb-20">
        <section class="mb-24">
            <h2 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Integrations') }}</h2>
            <div class="flex flex-wrap justify-center gap-3">
                @foreach ($integrations as $integration)
                    <div class="rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 px-5 py-2.5 text-sm text-zinc-700 dark:text-zinc-300">{{ $integration }}</div>
                @endforeach
            </div>
        </section>

        <section class="mb-24">
            <h2 class="mb-10 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('Pricing') }}</h2>
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

        <section>
            <h2 class="mb-8 text-center text-2xl font-bold text-zinc-900 dark:text-white">{{ __('FAQ') }}</h2>
            <div class="mx-auto max-w-2xl space-y-4">
                @foreach ($faqs as $faq)
                    <div class="rounded-lg border border-zinc-200 dark:border-white/10 p-5">
                        <p class="font-semibold text-zinc-900 dark:text-white">{{ __($faq['q']) }}</p>
                        <p class="mt-2 text-sm text-zinc-500">{{ $faq['a'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </main>
</div>
