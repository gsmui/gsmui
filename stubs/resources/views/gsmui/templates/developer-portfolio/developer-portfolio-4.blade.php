@props([
    'title' => 'Sarah Kim',
    'subtitle' => 'Software Engineer crafting elegant solutions for complex problems.',
    'services' => [
        ['icon' => 'code-bracket', 'name' => 'Web Development', 'desc' => 'Full-stack applications with modern frameworks and best practices.'],
        ['icon' => 'device-phone-mobile', 'name' => 'Mobile Apps', 'desc' => 'Cross-platform mobile experiences with native performance.'],
        ['icon' => 'cloud', 'name' => 'Cloud Architecture', 'desc' => 'Scalable infrastructure design and DevOps automation.'],
    ],
    'projects' => [
        ['name' => 'Task Manager Pro', 'desc' => 'Productivity app with real-time collaboration and Kanban boards.', 'image_placeholder' => '', 'tags' => ['React', 'Node.js', 'Socket.io']],
        ['name' => 'Weather Dashboard', 'desc' => 'Beautiful weather forecasts with interactive maps and alerts.', 'image_placeholder' => '', 'tags' => ['Vue.js', 'D3.js', 'API']],
        ['name' => 'Portfolio CMS', 'desc' => 'Headless content management system for creative portfolios.', 'image_placeholder' => '', 'tags' => ['Laravel', 'Livewire', 'Tailwind']],
        ['name' => 'Chat Widget', 'desc' => 'Embeddable real-time chat component with AI integration.', 'image_placeholder' => '', 'tags' => ['TypeScript', 'WebSocket', 'AI']],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$title" href="#" />
            <div class="hidden items-center gap-1 sm:flex">
                <gsmui:button variant="ghost" href="#services" size="sm">{{ __('Services') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#projects" size="sm">{{ __('Projects') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#testimonial" size="sm">{{ __('Testimonials') }}</gsmui:button>
                <gsmui:button variant="primary" size="sm" href="#contact" icon="envelope">{{ __('Hire Me') }}</gsmui:button>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6">
        <section class="py-20 text-center">
            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
            <div class="mt-8 flex justify-center gap-3">
                <gsmui:button variant="primary" href="#projects" icon="rocket-launch">{{ __('View Work') }}</gsmui:button>
                <gsmui:button variant="outline" href="#contact" icon="envelope">{{ __('Get in Touch') }}</gsmui:button>
            </div>
        </section>

        <section id="services" class="mb-20">
            <gsmui:divider text="{{ __('Services') }}" color="primary" align="center" />
            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                @foreach ($services as $service)
                    <gsmui:card variant="elevated" size="lg">
                        <div class="p-6 text-center">
                            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 dark:bg-indigo-500/10">
                                <gsmui:icon :name="$service['icon']" variant="outline" class="text-indigo-600 dark:text-indigo-400" />
                            </div>
                            <gsmui:heading size="lg" level="3">{{ __($service['name']) }}</gsmui:heading>
                            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __($service['desc']) }}</p>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        </section>

        <section id="projects" class="mb-20">
            <gsmui:divider text="{{ __('Featured Projects') }}" color="primary" align="center" />
            <div class="mt-10 grid gap-6 sm:grid-cols-2">
                @foreach ($projects as $project)
                    <gsmui:card variant="interactive">
                        <x-slot:image>
                            <div class="aspect-video bg-zinc-100 dark:bg-zinc-800"></div>
                        </x-slot:image>
                        <div class="p-5">
                            <gsmui:heading size="lg" level="3">{{ $project['name'] }}</gsmui:heading>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $project['desc'] }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($project['tags'] as $tag)
                                    <gsmui:badge color="indigo" rounded size="sm">{{ $tag }}</gsmui:badge>
                                @endforeach
                            </div>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        </section>

        <section id="testimonial" class="mb-20">
            <gsmui:divider text="{{ __('Testimonials') }}" color="primary" align="center" />
            <div class="mt-10">
                <gsmui:card variant="elevated" size="lg">
                    <div class="p-8 text-center">
                        <gsmui:icon name="heart" variant="mini" class="mx-auto mb-4 text-pink-400" />
                        <blockquote class="text-lg italic text-zinc-700 dark:text-zinc-300">
                            "{{ __('Sarah delivered our project ahead of schedule with exceptional quality. Her attention to detail and communication throughout the process was outstanding.') }}"
                        </blockquote>
                        <div class="mt-6">
                            <gsmui:avatar name="Michael Torres" size="sm" circle class="mx-auto" />
                            <gsmui:text variant="strong" class="mt-2">Michael Torres</gsmui:text>
                            <gsmui:text variant="subtle" size="sm">CTO, TechVentures Inc.</gsmui:text>
                        </div>
                    </div>
                </gsmui:card>
            </div>
        </section>

        <section id="contact" class="mb-20 text-center">
            <gsmui:heading size="xl" level="2">{{ __("Ready to Start?") }}</gsmui:heading>
            <p class="mt-3 text-zinc-500 dark:text-zinc-400">{{ __("Let's discuss your next project.") }}</p>
            <div class="mt-8 flex justify-center gap-3">
                <gsmui:button variant="primary" href="mailto:hello@example.com" icon="envelope">{{ __('Send Email') }}</gsmui:button>
                <gsmui:button variant="outline" href="#" icon="calendar">{{ __('Book a Call') }}</gsmui:button>
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-10">
        <div class="mx-auto grid max-w-6xl gap-8 px-6 sm:grid-cols-3">
            <div>
                <gsmui:brand :name="$title" href="#" />
                <p class="mt-2 text-sm text-zinc-500">{{ __('Building the web, one component at a time.') }}</p>
            </div>
            <div>
                <gsmui:heading size="default" level="4" class="mb-3">{{ __('Navigation') }}</gsmui:heading>
                <div class="space-y-2">
                    <p class="text-sm text-zinc-500 hover:text-indigo-500 cursor-pointer transition-colors">{{ __('Services') }}</p>
                    <p class="text-sm text-zinc-500 hover:text-indigo-500 cursor-pointer transition-colors">{{ __('Projects') }}</p>
                    <p class="text-sm text-zinc-500 hover:text-indigo-500 cursor-pointer transition-colors">{{ __('Contact') }}</p>
                </div>
            </div>
            <div>
                <gsmui:heading size="default" level="4" class="mb-3">{{ __('Connect') }}</gsmui:heading>
                <div class="flex gap-4">
                    <gsmui:icon name="code-bracket" class="text-zinc-400 hover:text-indigo-500 transition-colors cursor-pointer" />
                    <gsmui:icon name="globe" class="text-zinc-400 hover:text-indigo-500 transition-colors cursor-pointer" />
                    <gsmui:icon name="envelope" class="text-zinc-400 hover:text-indigo-500 transition-colors cursor-pointer" />
                </div>
            </div>
        </div>
        <div class="mt-8 border-t border-zinc-200 dark:border-white/10 pt-6 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
