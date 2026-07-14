@props([
    'title' => __('Crafting Digital Masterpieces'),
    'subtitle' => __('We bring bold ideas to life through design, code, and strategy.'),
    'projects' => [
        ['name' => 'Quantum Dashboard', 'desc' => 'A real-time analytics platform for enterprise data visualization.', 'tags' => ['React', 'D3.js', 'Node']],
        ['name' => 'Nebula E-Commerce', 'desc' => 'A high-conversion storefront with personalized shopping experiences.', 'tags' => ['Next.js', 'Stripe', 'Tailwind']],
        ['name' => 'Apex Mobile Suite', 'desc' => 'Cross-platform fitness tracking app with social features.', 'tags' => ['React Native', 'Firebase']],
    ],
    'capabilities' => [
        ['icon' => 'code-bracket', 'name' => 'Engineering'],
        ['icon' => 'sparkles', 'name' => 'Design'],
        ['icon' => 'chart-bar', 'name' => 'Analytics'],
        ['icon' => 'rocket-launch', 'name' => 'Growth'],
        ['icon' => 'shield-check', 'name' => 'Security'],
        ['icon' => 'cog-6-tooth', 'name' => 'DevOps'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 text-white') }}>
    <header class="border-b border-white/5">
        <div class="mx-auto max-w-7xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="Nexus" href="/" />
            <nav class="hidden md:flex items-center gap-8">
                <a href="#capabilities" class="text-sm text-zinc-500 hover:text-white">{{ __('Capabilities') }}</a>
                <a href="#projects" class="text-sm text-zinc-500 hover:text-white">{{ __('Projects') }}</a>
            </nav>
            <gsmui:button variant="outline" size="sm" class="border-cyan-500/30 text-cyan-400 hover:bg-cyan-500/10">{{ __('Get in Touch') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-7xl px-6 py-24 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <gsmui:heading size="xl" level="1" class="text-white">{{ $title }}</gsmui:heading>
            <gsmui:text variant="subtle" size="lg" class="mt-4 text-zinc-400">{{ $subtitle }}</gsmui:text>
            <div class="mt-8 flex gap-4">
                <gsmui:button variant="filled" size="default" class="bg-cyan-500 hover:bg-cyan-600 text-zinc-950 border-0">{{ __('Our Work') }}</gsmui:button>
                <gsmui:button variant="ghost" size="default" class="text-zinc-400 hover:text-white">{{ __('Contact') }}</gsmui:button>
            </div>
        </div>
        <div class="aspect-square rounded-2xl bg-gradient-to-br from-cyan-500/10 to-blue-500/10 border border-white/5 flex items-center justify-center">
            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-cyan-400/20 to-blue-500/20 flex items-center justify-center">
                <gsmui:icon name="globe" variant="outline" class="text-cyan-400 w-16 h-16" />
            </div>
        </div>
    </section>

    <section id="capabilities" class="py-24 bg-white/[0.02]">
        <div class="mx-auto max-w-7xl px-6">
            <gsmui:heading size="lg" level="2" class="text-center">{{ __('Our Capabilities') }}</gsmui:heading>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mt-12">
                @foreach ($capabilities as $cap)
                    <div class="text-center p-6 rounded-xl border border-white/5 hover:border-cyan-500/30 transition-colors">
                        <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-lg bg-cyan-500/10 mb-4">
                            <gsmui:icon name="{{ $cap['icon'] }}" class="text-cyan-400" />
                        </div>
                        <gsmui:text variant="strong" size="sm">{{ $cap['name'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="projects" class="mx-auto max-w-7xl px-6 py-24">
        <gsmui:heading size="lg" level="2">{{ __('Featured Projects') }}</gsmui:heading>
        <div class="grid md:grid-cols-3 gap-6 mt-12">
            @foreach ($projects as $project)
                <gsmui:card variant="ghost" class="bg-white/[0.03] border border-white/5 hover:border-cyan-500/20 transition-colors">
                    <div class="aspect-video bg-gradient-to-br from-zinc-800 to-zinc-900 flex items-center justify-center">
                        <gsmui:icon name="photo" variant="outline" class="text-zinc-700 w-10 h-10" />
                    </div>
                    <div class="p-6">
                        <gsmui:heading size="default" level="3">{{ $project['name'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" size="sm" class="mt-2 text-zinc-400">{{ $project['desc'] }}</gsmui:text>
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach ($project['tags'] as $tag)
                                <gsmui:badge color="cyan" variant="solid" rounded>{{ $tag }}</gsmui:badge>
                            @endforeach
                        </div>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="py-24 text-center bg-gradient-to-b from-transparent to-cyan-500/5">
        <gsmui:heading size="lg" level="2" class="text-white">{{ __('Let\'s Build Something Bold') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-4 text-zinc-400">{{ __('Ready to push boundaries together?') }}</gsmui:text>
        <gsmui:button variant="filled" size="default" class="mt-8 bg-cyan-500 hover:bg-cyan-600 text-zinc-950 border-0">{{ __('Start a Conversation') }}</gsmui:button>
    </section>

    <footer class="border-t border-white/5 py-12">
        <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <gsmui:brand name="Nexus" href="/" />
            <gsmui:text variant="subtle" size="sm" class="text-zinc-600">&copy; {{ date('Y') }} Nexus Agency. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
