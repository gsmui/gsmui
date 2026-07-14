@props([
    'title' => 'Emma Nakamura',
    'subtitle' => 'Experience Designer',
    'steps' => [
        ['number' => '01', 'title' => 'Empathize', 'desc' => 'Deep user interviews and contextual inquiry to understand real needs, pain points, and motivations behind user behavior.', 'icon' => 'users'],
        ['number' => '02', 'title' => 'Ideate', 'desc' => 'Collaborative workshops and rapid sketching sessions to explore diverse solutions before committing to a direction.', 'icon' => 'light-bulb'],
        ['number' => '03', 'title' => 'Prototype', 'desc' => 'High-fidelity interactive prototypes that test assumptions early and gather actionable feedback from real users.', 'icon' => 'sparkles'],
        ['number' => '04', 'title' => 'Iterate', 'desc' => 'Data-informed refinements through usability testing, A/B experiments, and continuous improvement cycles.', 'icon' => 'rocket-launch'],
    ],
    'projects' => [
        ['name' => 'EdTech Learning Platform', 'desc' => 'Redesigned the student learning experience with adaptive pathways and gamified progress tracking.'],
        ['name' => 'Restaurant Ordering System', 'desc' => 'Streamlined the digital ordering flow, reducing average order time by 45% across 200+ locations.'],
        ['name' => 'Climate Data Dashboard', 'desc' => 'Visualized complex environmental datasets into actionable insights for policy makers and researchers.'],
        ['name' => 'Accessibility Audit Tool', 'desc' => 'Built a designer-facing tool that automatically checks WCAG compliance across Figma artboards.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden items-center gap-6 text-sm text-zinc-600 dark:text-zinc-400 md:flex">
                <a href="#process" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Process') }}</a>
                <a href="#work" class="hover:text-zinc-900 dark:hover:text-white transition-colors {{ __('Work') }}">{{ __('Work') }}</a>
                <a href="#contact" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Contact') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm" href="#contact">{{ __('Hire Me') }}</gsmui:button>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6">
        <section class="py-24 text-center">
            <gsmui:badge color="emerald" class="mb-6">{{ __('Open to opportunities') }}</gsmui:badge>
            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <gsmui:heading size="lg" level="2" class="mt-2 text-emerald-600 dark:text-emerald-400">{{ $subtitle }}</gsmui:heading>
            <gsmui:text size="lg" variant="subtle" class="mx-auto mt-4 max-w-2xl">{{ __('Human-centered design with a focus on measurable impact and delightful user experiences.') }}</gsmui:text>
        </section>

        <section id="process" class="pb-24">
            <gsmui:divider text="{{ __('Design Process') }}" color="primary" />
            <div class="relative mt-12">
                <div class="absolute left-6 top-0 bottom-0 w-px bg-emerald-200 dark:bg-emerald-800 sm:left-8"></div>
                <div class="space-y-12">
                    @foreach ($steps as $step)
                        <div class="relative flex gap-6 pl-16 sm:pl-20">
                            <div class="absolute left-0 flex h-12 w-12 items-center justify-center rounded-full border-2 border-emerald-200 dark:border-emerald-800 bg-white dark:bg-zinc-900">
                                <gsmui:icon :name="$step['icon']" variant="outline" class="h-5 w-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <gsmui:text size="sm" variant="subtle" class="font-mono text-emerald-600 dark:text-emerald-400">{{ $step['number'] }}</gsmui:text>
                                <gsmui:heading size="default" level="3" class="mt-1">{{ $step['title'] }}</gsmui:heading>
                                <gsmui:text variant="subtle" class="mt-2">{{ $step['desc'] }}</gsmui:text>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="work" class="pb-24">
            <gsmui:divider text="{{ __('Selected Works') }}" color="primary" />
            <div class="mt-12 grid gap-6 sm:grid-cols-2">
                @foreach ($projects as $project)
                    <gsmui:card variant="interactive">
                        <div class="p-6">
                            <div class="mb-4 h-32 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                                <gsmui:icon name="photo" variant="outline" class="h-8 w-8 text-emerald-300 dark:text-emerald-500/30" />
                            </div>
                            <gsmui:heading size="default" level="3">{{ $project['name'] }}</gsmui:heading>
                            <gsmui:text variant="subtle" size="sm" class="mt-2">{{ $project['desc'] }}</gsmui:text>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        </section>

        <section class="pb-24">
            <gsmui:divider text="{{ __('Kind Words') }}" color="primary" />
            <gsmui:card variant="default" class="mt-12 text-center">
                <div class="px-8 py-10">
                    <gsmui:icon name="star" variant="solid" class="mx-auto mb-4 h-8 w-8 text-amber-400" />
                    <gsmui:text size="lg" class="italic text-zinc-700 dark:text-zinc-300">"{{ __('Emma\'s design process is second to none. She brought clarity to our most complex user flows and delivered results that exceeded every metric we set.') }}"</gsmui:text>
                    <div class="mt-6 flex items-center justify-center gap-3">
                        <gsmui:avatar name="David Park" size="sm" circle />
                        <div class="text-left">
                            <gsmui:text variant="strong" size="sm">David Park</gsmui:text>
                            <gsmui:text size="sm" variant="subtle">{{ __('VP of Product, TechCorp') }}</gsmui:text>
                        </div>
                    </div>
                </div>
            </gsmui:card>
        </section>

        <section id="contact" class="border-t border-zinc-200 dark:border-white/10 py-24 text-center">
            <gsmui:heading size="lg" level="2">{{ __('Start a conversation') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mt-3">{{ __('Whether it\'s a full project or a quick chat, I\'d love to connect.') }}</gsmui:text>
            <gsmui:button variant="filled" class="mt-8" href="mailto:hello@example.com">{{ __('Say Hello') }}</gsmui:button>
        </section>
    </main>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-8 text-center text-sm text-zinc-500">
        &copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}
    </footer>
</div>
