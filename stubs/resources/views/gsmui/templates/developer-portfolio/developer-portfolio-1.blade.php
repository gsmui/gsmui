@props([
    'title' => 'Alex Chen',
    'subtitle' => 'Full-Stack Developer & Open Source Enthusiast',
    'github' => ['repos' => 84, 'stars' => '3.2k', 'followers' => 512],
    'skills' => [
        ['name' => 'Laravel', 'level' => 95],
        ['name' => 'Vue.js', 'level' => 88],
        ['name' => 'React', 'level' => 82],
        ['name' => 'TypeScript', 'level' => 90],
        ['name' => 'Docker', 'level' => 78],
        ['name' => 'PostgreSQL', 'level' => 85],
    ],
    'projects' => [
        ['name' => 'SaaS Dashboard', 'desc' => 'Real-time analytics platform for enterprise teams.', 'tech' => ['Laravel', 'Vue.js', 'Tailwind'], 'stars' => 342],
        ['name' => 'E-Commerce API', 'desc' => 'High-performance REST API with GraphQL gateway.', 'tech' => ['Node.js', 'PostgreSQL', 'Redis'], 'stars' => 189],
        ['name' => 'CLI Toolkit', 'desc' => 'Developer tools for automating deployment workflows.', 'tech' => ['Go', 'Docker', 'Bash'], 'stars' => 567],
        ['name' => 'Auth Microservice', 'desc' => 'Zero-trust authentication with OAuth2 and RBAC.', 'tech' => ['Rust', 'gRPC', 'JWT'], 'stars' => 234],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 text-white') }}>
    <header class="sticky top-0 z-50 border-b border-white/10 bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden items-center gap-1 sm:flex">
                <gsmui:button variant="ghost" href="#projects" size="sm">{{ __('Projects') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#skills" size="sm">{{ __('Skills') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#about" size="sm">{{ __('About') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#contact" size="sm">{{ __('Contact') }}</gsmui:button>
            </nav>
            <div class="sm:hidden">
                <gsmui:icon name="cog-6-tooth" class="text-zinc-400" />
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 py-20">
        <section class="mb-24">
            <gsmui:badge color="green" rounded class="mb-6">{{ __('Available for hire') }}</gsmui:badge>
            <gsmui:heading size="xl" level="1" class="bg-gradient-to-r from-green-400 to-cyan-400 bg-clip-text text-transparent">{{ $title }}</gsmui:heading>
            <p class="mt-3 max-w-2xl text-lg text-zinc-400">{{ $subtitle }}</p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <gsmui:badge color="zinc" variant="solid" rounded>{{ $github['repos'] }} {{ __('repos') }}</gsmui:badge>
                <gsmui:badge color="amber" variant="solid" rounded><gsmui:icon name="star" variant="mini" class="inline-block mr-1" />{{ $github['stars'] }} {{ __('stars') }}</gsmui:badge>
                <gsmui:badge color="cyan" variant="solid" rounded><gsmui:icon name="users" variant="mini" class="inline-block mr-1" />{{ $github['followers'] }} {{ __('followers') }}</gsmui:badge>
            </div>
            <div class="mt-10 flex flex-wrap gap-3">
                <gsmui:button variant="primary" href="#projects" icon="code-bracket">{{ __('View Projects') }}</gsmui:button>
                <gsmui:button variant="outline" href="#contact" icon="envelope">{{ __('Get in Touch') }}</gsmui:button>
            </div>
        </section>

        <section id="skills" class="mb-24">
            <gsmui:divider text="{{ __('Technical Skills') }}" color="primary" align="start" />
            <div class="mt-8 grid gap-5 sm:grid-cols-2">
                @foreach ($skills as $skill)
                    <div>
                        <div class="mb-2 flex justify-between text-sm">
                            <gsmui:text variant="strong">{{ $skill['name'] }}</gsmui:text>
                            <gsmui:text variant="subtle" size="sm">{{ $skill['level'] }}%</gsmui:text>
                        </div>
                        <gsmui:progress :value="$skill['level']" color="emerald" />
                    </div>
                @endforeach
            </div>
        </section>

        <section id="projects" class="mb-24">
            <gsmui:divider text="{{ __('Featured Projects') }}" color="primary" align="start" />
            <div class="mt-8 grid gap-6 sm:grid-cols-2">
                @foreach ($projects as $project)
                    <gsmui:card variant="interactive" size="sm">
                        <div class="p-5">
                            <div class="mb-3 flex items-start justify-between">
                                <gsmui:heading size="lg" level="3">{{ $project['name'] }}</gsmui:heading>
                                <gsmui:badge color="amber" size="sm" rounded><gsmui:icon name="star" variant="mini" class="inline-block mr-1" />{{ $project['stars'] }}</gsmui:badge>
                            </div>
                            <p class="text-sm text-zinc-400">{{ $project['desc'] }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($project['tech'] as $tech)
                                    <gsmui:badge color="zinc" size="sm">{{ $tech }}</gsmui:badge>
                                @endforeach
                            </div>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        </section>

        <section id="contact" class="mb-24 text-center">
            <gsmui:heading size="xl" level="2">{{ __("Let's Build Together") }}</gsmui:heading>
            <p class="mt-3 text-zinc-400">{{ __('Open to collaborations, consulting, and new opportunities.') }}</p>
            <div class="mt-8 flex justify-center gap-3">
                <gsmui:button variant="primary" href="mailto:hello@example.com" icon="envelope">{{ __('Email Me') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#" icon="code-bracket">{{ __('GitHub') }}</gsmui:button>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 py-8">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $title }}</gsmui:text>
            <div class="flex gap-4">
                <gsmui:icon name="code-bracket" class="text-zinc-600 hover:text-green-400 transition-colors cursor-pointer" />
                <gsmui:icon name="globe" class="text-zinc-600 hover:text-green-400 transition-colors cursor-pointer" />
                <gsmui:icon name="envelope" class="text-zinc-600 hover:text-green-400 transition-colors cursor-pointer" />
            </div>
        </div>
    </footer>
</div>
