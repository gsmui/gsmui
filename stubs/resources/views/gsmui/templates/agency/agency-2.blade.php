@props([
    'title' => __('We Create What Others Imagine'),
    'subtitle' => __('A creative studio pushing the boundaries of design and technology.'),
    'works' => [
        ['name' => 'Nova Brand Identity', 'client' => 'Nova Corp', 'category' => 'Branding'],
        ['name' => 'Pulse App Design', 'client' => 'Pulse Health', 'category' => 'UI/UX'],
        ['name' => 'Atlas Website', 'client' => 'Atlas Ventures', 'category' => 'Web Design'],
        ['name' => 'Echo Campaign', 'client' => 'Echo Media', 'category' => 'Marketing'],
    ],
    'services' => [
        ['name' => 'Brand Strategy', 'desc' => 'We define your brand\'s voice, vision, and visual identity to stand out in a crowded market.'],
        ['name' => 'Digital Design', 'desc' => 'Pixel-perfect interfaces and experiences that captivate users and drive results.'],
        ['name' => 'Motion & Video', 'desc' => 'Dynamic animations and video content that bring your brand story to life.'],
        ['name' => 'Creative Direction', 'desc' => 'Strategic creative leadership to ensure consistency across all touchpoints.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-900 text-white') }}>
    <header class="border-b border-white/10">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="Creativo" href="/" />
            <nav class="hidden md:flex items-center gap-8">
                <a href="#works" class="text-sm text-zinc-400 hover:text-white">{{ __('Works') }}</a>
                <a href="#services" class="text-sm text-zinc-400 hover:text-white">{{ __('Services') }}</a>
            </nav>
            <gsmui:button variant="outline" size="sm" class="border-white/20 text-white hover:bg-white/10">{{ __('Let\'s Talk') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-7xl px-6 py-32">
        <gsmui:heading size="xl" level="1" class="max-w-4xl">
            <span class="bg-gradient-to-r from-violet-400 via-pink-500 to-orange-400 bg-clip-text text-transparent">{{ $title }}</span>
        </gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-6 max-w-2xl text-zinc-400">{{ $subtitle }}</gsmui:text>
        <div class="mt-10 flex gap-4">
            <gsmui:button variant="filled" size="default" class="bg-gradient-to-r from-violet-500 to-pink-500 hover:from-violet-600 hover:to-pink-600 text-white border-0">{{ __('View Our Work') }}</gsmui:button>
            <gsmui:button variant="ghost" size="default" class="text-zinc-300 hover:text-white">{{ __('Our Process') }}</gsmui:button>
        </div>
    </section>

    <section id="works" class="mx-auto max-w-7xl px-6 py-24">
        <gsmui:heading size="lg" level="2">{{ __('Selected Works') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-3 text-zinc-400">{{ __('Projects we\'re proud of.') }}</gsmui:text>
        <div class="grid md:grid-cols-2 gap-6 mt-12">
            @foreach ($works as $work)
                <gsmui:card variant="ghost" class="group bg-zinc-800/50 border border-white/5 hover:border-white/10 transition-colors overflow-hidden">
                    <div class="aspect-video bg-gradient-to-br from-zinc-700 to-zinc-800 flex items-center justify-center">
                        <gsmui:icon name="photo" variant="outline" class="text-zinc-600 w-12 h-12" />
                    </div>
                    <div class="p-6">
                        <gsmui:badge color="violet" variant="solid" rounded>{{ $work['category'] }}</gsmui:badge>
                        <gsmui:heading size="default" level="3" class="mt-3">{{ $work['name'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" size="sm" class="mt-1 text-zinc-400">{{ __('Client: :client', ['client' => $work['client']]) }}</gsmui:text>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section id="services" class="py-24 bg-zinc-800/30">
        <div class="mx-auto max-w-7xl px-6">
            <gsmui:heading size="lg" level="2" class="text-center">{{ __('What We Do') }}</gsmui:heading>
            <div class="mt-16 space-y-16">
                @foreach ($services as $index => $service)
                    <div class="flex flex-col md:flex-row {{ $index % 2 === 1 ? 'md:flex-row-reverse' : '' }} items-center gap-8">
                        <div class="flex-1">
                            <gsmui:heading size="default" level="3">{{ $service['name'] }}</gsmui:heading>
                            <gsmui:text variant="subtle" class="mt-3 text-zinc-400">{{ $service['desc'] }}</gsmui:text>
                        </div>
                        <div class="flex-1 aspect-video bg-gradient-to-br from-zinc-700 to-zinc-800 rounded-xl flex items-center justify-center">
                            <gsmui:icon name="sparkles" variant="outline" class="text-zinc-600 w-12 h-12" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-32 text-center">
        <gsmui:heading size="xl" level="2">{{ __('Ready to Create Something Amazing?') }}</gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-4 text-zinc-400">{{ __('Let\'s turn your vision into reality.') }}</gsmui:text>
        <gsmui:button variant="filled" size="default" class="mt-8 bg-gradient-to-r from-violet-500 to-pink-500 hover:from-violet-600 hover:to-pink-600 text-white border-0">{{ __('Start a Project') }}</gsmui:button>
    </section>

    <footer class="border-t border-white/10 py-12">
        <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <gsmui:brand name="Creativo" href="/" />
            <gsmui:text variant="subtle" size="sm" class="text-zinc-500">&copy; {{ date('Y') }} Creativo Studio. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
