@props([
    'name' => 'NeuralForge',
    'tagline' => 'Powered by next-generation AI.',
    'features' => [
        ['title' => 'Autonomous Agents', 'desc' => 'AI agents that complete multi-step tasks independently.'],
        ['title' => 'Knowledge Graphs', 'desc' => 'Connect and query your organization\'s knowledge.'],
        ['title' => 'Real-time Learning', 'desc' => 'Models that improve with every interaction.'],
        ['title' => 'Multi-language', 'desc' => 'Support for 95+ languages out of the box.'],
    ],
    'enterprise' => [
        ['label' => 'Uptime SLA', 'value' => '99.99%'],
        ['label' => 'Data Centers', 'value' => '12 regions'],
        ['label' => 'Response Time', 'value' => '<100ms'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 text-white') }}>
    <header class="sticky top-0 z-50 border-b border-white/10 bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$name" class="text-white" />
            <gsmui:button size="sm" variant="primary" class="bg-violet-600 hover:bg-violet-700">{{ __('Request Access') }}</gsmui:button>
        </div>
    </header>

    <section class="relative px-6 py-32 text-center overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute left-1/4 top-1/4 h-64 w-64 rounded-full bg-violet-500 blur-[100px]"></div>
            <div class="absolute right-1/4 bottom-1/4 h-64 w-64 rounded-full bg-blue-500 blur-[100px]"></div>
        </div>
        <div class="relative">
            <gsmui:badge color="violet" class="mb-6">{{ __('Powered by AI') }}</gsmui:badge>
            <h1 class="text-6xl font-bold tracking-tight">{{ $tagline }}</h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-zinc-400">{{ __('Build intelligent applications with our state-of-the-art AI infrastructure.') }}</p>
            <div class="mt-10 flex justify-center gap-4">
                <gsmui:button variant="primary" size="lg" class="bg-violet-600 hover:bg-violet-700">{{ __('Get API Key') }}</gsmui:button>
                <gsmui:button variant="outline" size="lg" class="border-white/20 text-white hover:bg-white/10">{{ __('Documentation') }}</gsmui:button>
            </div>
        </div>
    </section>

    <main class="mx-auto max-w-6xl px-6 pb-20">
        <section class="mb-24">
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-white/10 bg-white/5 p-8 backdrop-blur-sm">
                        <div class="mb-4 h-10 w-10 rounded-lg bg-violet-500/20"></div>
                        <h3 class="text-lg font-semibold">{{ __($feature['title']) }}</h3>
                        <p class="mt-2 text-sm text-zinc-400">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="mb-24 rounded-2xl border border-white/10 bg-white/5 p-12">
            <h2 class="mb-8 text-center text-2xl font-bold">{{ __('Enterprise Grade') }}</h2>
            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($enterprise as $metric)
                    <div class="text-center">
                        <p class="text-3xl font-bold text-violet-400">{{ $metric['value'] }}</p>
                        <p class="mt-2 text-sm text-zinc-500">{{ __($metric['label']) }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-2xl bg-gradient-to-r from-violet-600 to-blue-600 p-12 text-center">
            <h2 class="text-3xl font-bold">{{ __('Ready to build with AI?') }}</h2>
            <p class="mt-3 text-violet-100">{{ __('Start with 10,000 free API calls per month.') }}</p>
            <gsmui:button class="mt-6 bg-white text-violet-600 hover:bg-zinc-100">{{ __('Get Started Free') }}</gsmui:button>
        </section>
    </main>
</div>
