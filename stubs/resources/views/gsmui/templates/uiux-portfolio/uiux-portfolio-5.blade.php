@props([
    'title' => 'Jordan Blake',
    'subtitle' => 'Product & Interaction Designer',
    'projects' => [
        ['name' => 'Autonomous Vehicle UI', 'desc' => 'Designed the in-car interface for a self-driving fleet, balancing safety-critical information with passenger comfort.', 'tags' => ['Automotive', 'HMI', 'Safety']],
        ['name' => 'Creator Economy Platform', 'desc' => 'Built the end-to-end experience for creators to monetize content, manage audiences, and track analytics.', 'tags' => ['SaaS', 'Web App', 'Analytics']],
        ['name' => 'Public Transit App', 'desc' => 'Reimagined urban mobility with real-time trip planning, accessibility-first design, and offline capabilities.', 'tags' => ['Mobile', 'Accessibility', 'Maps']],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden items-center gap-6 text-sm text-zinc-600 dark:text-zinc-400 md:flex">
                <a href="#projects" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Projects') }}</a>
                <a href="#about" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('About') }}</a>
                <a href="#contact" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Contact') }}</a>
            </nav>
            <gsmui:button variant="outline" size="sm" href="#contact">{{ __('Let\'s Collaborate') }}</gsmui:button>
        </div>
    </header>

    <section class="relative overflow-hidden bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 px-6 py-32 text-center">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-500/10 via-transparent to-purple-500/10"></div>
        <div class="relative mx-auto max-w-4xl">
            <gsmui:heading size="xl" level="1" class="text-white">{{ $title }}</gsmui:heading>
            <gsmui:text size="xl" class="mt-4 text-zinc-300">{{ $subtitle }}</gsmui:text>
            <gsmui:text variant="subtle" class="mx-auto mt-6 max-w-2xl text-zinc-400">{{ __('Designing at the intersection of technology and humanity. Currently shaping the future of digital experiences.') }}</gsmui:text>
            <div class="mt-10 flex justify-center gap-4">
                <gsmui:button variant="filled" href="#projects">{{ __('View Projects') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#contact" class="text-zinc-300 hover:text-white">{{ __('Get in Touch') }}</gsmui:button>
            </div>
        </div>
    </section>

    <main>
        <section id="projects" class="mx-auto max-w-6xl px-6 py-24">
            <gsmui:heading size="lg" level="2" class="mb-2">{{ __('Selected Projects') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mb-12">{{ __('Full-width explorations of meaningful design work.') }}</gsmui:text>
            <div class="space-y-8">
                @foreach ($projects as $project)
                    <gsmui:card variant="interactive" class="group overflow-hidden">
                        <div class="grid lg:grid-cols-2">
                            <div class="aspect-video bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center lg:aspect-auto">
                                <gsmui:icon name="photo" variant="outline" class="h-16 w-16 text-indigo-300 dark:text-indigo-500/30" />
                            </div>
                            <div class="flex flex-col justify-center p-8">
                                <gsmui:heading size="default" level="3">{{ $project['name'] }}</gsmui:heading>
                                <gsmui:text variant="subtle" class="mt-3">{{ $project['desc'] }}</gsmui:text>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach ($project['tags'] as $tag)
                                        <gsmui:badge color="indigo">{{ $tag }}</gsmui:badge>
                                    @endforeach
                                </div>
                                <gsmui:button variant="ghost" size="sm" iconTrailing="chevron-down" class="mt-6 self-start">{{ __('View Case Study') }}</gsmui:button>
                            </div>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        </section>

        <section id="about" class="border-t border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-800/50 px-6 py-24">
            <div class="mx-auto grid max-w-6xl items-center gap-12 lg:grid-cols-2">
                <div>
                    <gsmui:heading size="lg" level="2">{{ __('About Me') }}</gsmui:heading>
                    <gsmui:text variant="subtle" class="mt-4">{{ __('With 8+ years of experience across automotive, fintech, and consumer products, I bring a systems-thinking approach to every project. I believe great design is invisible — it simply works.') }}</gsmui:text>
                    <gsmui:text variant="subtle" class="mt-4">{{ __('I hold a Master\'s in Human-Computer Interaction and have contributed to products used by millions of people worldwide.') }}</gsmui:text>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <gsmui:card variant="flat" size="sm" class="text-center p-6">
                        <gsmui:heading size="default" level="3" class="text-indigo-600 dark:text-indigo-400">50+</gsmui:heading>
                        <gsmui:text size="sm" variant="subtle" class="mt-1">{{ __('Projects') }}</gsmui:text>
                    </gsmui:card>
                    <gsmui:card variant="flat" size="sm" class="text-center p-6">
                        <gsmui:heading size="default" level="3" class="text-indigo-600 dark:text-indigo-400">8+</gsmui:heading>
                        <gsmui:text size="sm" variant="subtle" class="mt-1">{{ __('Years Experience') }}</gsmui:text>
                    </gsmui:card>
                    <gsmui:card variant="flat" size="sm" class="text-center p-6">
                        <gsmui:heading size="default" level="3" class="text-indigo-600 dark:text-indigo-400">12M+</gsmui:heading>
                        <gsmui:text size="sm" variant="subtle" class="mt-1">{{ __('Users Impacted') }}</gsmui:text>
                    </gsmui:card>
                    <gsmui:card variant="flat" size="sm" class="text-center p-6">
                        <gsmui:heading size="default" level="3" class="text-indigo-600 dark:text-indigo-400">5</gsmui:heading>
                        <gsmui:text size="sm" variant="subtle" class="mt-1">{{ __('Design Awards') }}</gsmui:text>
                    </gsmui:card>
                </div>
            </div>
        </section>

        <section class="px-6 py-16">
            <div class="mx-auto max-w-6xl">
                <gsmui:heading size="lg" level="2" class="mb-8 text-center">{{ __('Core Skills') }}</gsmui:heading>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach (['UX Strategy', 'Interaction Design', 'Prototyping', 'User Research', 'Design Systems', 'Motion Design'] as $skill)
                        <gsmui:card variant="flat" size="sm" class="text-center p-4">
                            <gsmui:text variant="strong" size="sm">{{ __($skill) }}</gsmui:text>
                        </gsmui:card>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="contact" class="bg-zinc-900 dark:bg-zinc-950 px-6 py-24 text-center">
            <div class="mx-auto max-w-xl">
                <gsmui:heading size="lg" level="2" class="text-white">{{ __("Let's build something remarkable") }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mt-3 text-zinc-400">{{ __('I\'m always interested in challenging projects that push the boundaries of what\'s possible.') }}</gsmui:text>
                <gsmui:button variant="filled" class="mt-8" href="mailto:hello@example.com">{{ __('Start a Conversation') }}</gsmui:button>
            </div>
        </section>
    </main>

    <footer class="bg-zinc-950 py-8 text-center text-sm text-zinc-600">
        &copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}
    </footer>
</div>
