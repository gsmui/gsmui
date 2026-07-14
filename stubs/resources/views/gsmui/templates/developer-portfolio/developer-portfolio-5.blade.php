@props([
    'title' => 'Kai Nakamura',
    'subtitle' => 'Creative Developer & Digital Craftsman',
    'nav_items' => ['About', 'Skills', 'Experience', 'Contact'],
    'skills' => [
        ['name' => 'React / Next.js', 'level' => 92],
        ['name' => 'TypeScript', 'level' => 90],
        ['name' => 'Node.js', 'level' => 85],
        ['name' => 'Three.js / WebGL', 'level' => 78],
        ['name' => 'Python', 'level' => 80],
        ['name' => 'AWS / DevOps', 'level' => 75],
    ],
    'experience' => [
        ['company' => 'Nexus Labs', 'role' => 'Senior Frontend Engineer', 'period' => '2022 — Present', 'desc' => 'Leading the design system team, building reusable component libraries used across 12 products.'],
        ['company' => 'PixelForge', 'role' => 'Full-Stack Developer', 'period' => '2020 — 2022', 'desc' => 'Built real-time collaboration features and performance-optimized rendering pipelines.'],
        ['company' => 'WebCraft Agency', 'role' => 'Junior Developer', 'period' => '2018 — 2020', 'desc' => 'Developed client websites and e-commerce platforms with a focus on accessibility.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950 lg:flex') }}>
    <aside class="fixed inset-y-0 left-0 z-50 flex w-full flex-col bg-zinc-900 text-white lg:w-64">
        <div class="flex flex-1 flex-col justify-between p-6">
            <div>
                <div class="flex items-center justify-between lg:block">
                    <div class="flex items-center gap-3 lg:block lg:text-center">
                        <gsmui:avatar :name="$title" size="lg" circle class="lg:mx-auto" />
                        <div class="lg:mt-4">
                            <gsmui:heading size="lg" level="1">{{ $title }}</gsmui:heading>
                            <gsmui:text variant="subtle" size="sm">{{ $subtitle }}</gsmui:text>
                        </div>
                    </div>
                </div>
                <nav class="mt-8 space-y-1">
                    @foreach ($nav_items as $item)
                        <a href="#{{ Str::slug($item) }}" class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-sm text-zinc-400 hover:bg-white/10 hover:text-white transition-colors">
                            {{ __($item) }}
                        </a>
                    @endforeach
                </nav>
            </div>
            <div class="flex justify-center gap-4">
                <gsmui:icon name="code-bracket" class="text-zinc-500 hover:text-white transition-colors cursor-pointer" />
                <gsmui:icon name="globe" class="text-zinc-500 hover:text-white transition-colors cursor-pointer" />
                <gsmui:icon name="envelope" class="text-zinc-500 hover:text-white transition-colors cursor-pointer" />
            </div>
        </div>
    </aside>

    <main class="flex-1 lg:ml-64">
        <div class="mx-auto max-w-3xl px-6 py-16 lg:px-12">
            <section id="about" class="mb-20">
                <gsmui:heading size="xl" level="2">{{ __('About Me') }}</gsmui:heading>
                <p class="mt-4 text-zinc-600 dark:text-zinc-400 leading-relaxed">
                    {{ __("I'm a creative developer with a passion for building beautiful, performant web experiences. With over 6 years of experience, I bridge the gap between design and engineering, crafting interfaces that delight users and scale reliably.") }}
                </p>
                <p class="mt-4 text-zinc-600 dark:text-zinc-400 leading-relaxed">
                    {{ __("When I'm not coding, you'll find me exploring generative art, contributing to open source, or hiking in the mountains.") }}
                </p>
            </section>

            <section id="skills" class="mb-20">
                <gsmui:divider text="{{ __('Technical Skills') }}" color="primary" align="start" />
                <div class="mt-8 grid gap-5 sm:grid-cols-2">
                    @foreach ($skills as $skill)
                        <div>
                            <div class="mb-2 flex justify-between text-sm">
                                <gsmui:text variant="strong">{{ $skill['name'] }}</gsmui:text>
                                <gsmui:text variant="subtle" size="sm">{{ $skill['level'] }}%</gsmui:text>
                            </div>
                            <gsmui:progress :value="$skill['level']" color="violet" />
                        </div>
                    @endforeach
                </div>
            </section>

            <section id="experience" class="mb-20">
                <gsmui:divider text="{{ __('Experience') }}" color="primary" align="start" />
                <div class="mt-8 space-y-8">
                    @foreach ($experience as $exp)
                        <gsmui:card variant="outlined">
                            <div class="p-5">
                                <div class="flex flex-wrap items-start justify-between gap-2">
                                    <div>
                                        <gsmui:heading size="lg" level="3">{{ $exp['role'] }}</gsmui:heading>
                                        <gsmui:text variant="subtle">{{ $exp['company'] }}</gsmui:text>
                                    </div>
                                    <gsmui:badge color="zinc" rounded size="sm">{{ $exp['period'] }}</gsmui:badge>
                                </div>
                                <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">{{ __($exp['desc']) }}</p>
                            </div>
                        </gsmui:card>
                    @endforeach
                </div>
            </section>

            <section id="contact" class="mb-20">
                <gsmui:divider text="{{ __('Get in Touch') }}" color="primary" align="start" />
                <div class="mt-8 space-y-4">
                    <gsmui:input type="text" placeholder="{{ __('Your name') }}" icon="user" />
                    <gsmui:input type="email" placeholder="{{ __('Email address') }}" icon="envelope" />
                    <textarea rows="4" placeholder="{{ __('Your message...') }}" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-white/10 px-4 py-3 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400"></textarea>
                    <gsmui:button variant="primary" class="w-full" icon="envelope">{{ __('Send Message') }}</gsmui:button>
                </div>
            </section>
        </div>
    </main>
</div>
