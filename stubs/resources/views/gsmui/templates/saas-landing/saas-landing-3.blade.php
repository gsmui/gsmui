@props([
    'name' => 'ZenOps',
    'tagline' => 'Deploy with confidence.',
    'features' => ['Zero-downtime deployments', 'Automatic rollbacks', 'Real-time monitoring'],
    'testimonial' => [
        'quote' => 'ZenOps simplified our entire deployment pipeline. We went from hours to minutes.',
        'author' => 'David L., VP Engineering at ScaleUp',
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950 flex flex-col') }}>
    <header class="px-6 py-6">
        <div class="mx-auto flex max-w-3xl items-center justify-between">
            <gsmui:brand :name="$name" />
            <span class="text-sm text-zinc-500 cursor-pointer">{{ __('Learn More') }}</span>
        </div>
    </header>

    <main class="flex flex-1 flex-col items-center justify-center px-6 py-20 text-center">
        <h1 class="text-6xl font-bold tracking-tight text-zinc-900 dark:text-white">{{ $tagline }}</h1>
        <p class="mx-auto mt-6 max-w-lg text-xl text-zinc-500">{{ __('The simplest way to deploy your applications. No config files. No YAML. Just push and ship.') }}</p>
        <gsmui:button variant="primary" size="lg" class="mt-10">{{ __('Start Deploying Free') }}</gsmui:button>

        <div class="mt-16 flex flex-col items-start gap-4 text-left sm:flex-row sm:gap-12">
            @foreach ($features as $feature)
                <div class="flex items-center gap-2">
                    <span class="text-emerald-500">✓</span>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __($feature) }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-20 max-w-lg rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 p-8 text-left">
            <p class="text-zinc-600 dark:text-zinc-400 italic">"{{ $testimonial['quote'] }}"</p>
            <p class="mt-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ $testimonial['author'] }}</p>
        </div>
    </main>

    <footer class="px-6 py-8 text-center text-sm text-zinc-400">
        &copy; {{ date('Y') }} {{ $name }}.
    </footer>
</div>
