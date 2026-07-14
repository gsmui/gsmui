@props([
    'title' => 'Sarah Kim',
    'subtitle' => 'UI/UX Designer crafting intuitive digital experiences that delight users and drive business growth.',
    'projects' => [
        ['name' => 'FinTech Dashboard', 'category' => 'Product Design', 'color' => 'bg-violet-500'],
        ['name' => 'Wellness App', 'category' => 'Mobile Design', 'color' => 'bg-pink-500'],
        ['name' => 'E-Commerce Redesign', 'category' => 'Web Design', 'color' => 'bg-sky-500'],
        ['name' => 'Smart Home UI', 'category' => 'IoT Design', 'color' => 'bg-amber-500'],
        ['name' => 'Travel Platform', 'category' => 'UX Research', 'color' => 'bg-emerald-500'],
        ['name' => 'Social Analytics', 'category' => 'Data Viz', 'color' => 'bg-indigo-500'],
    ],
    'skills' => [
        ['name' => 'User Research', 'icon' => 'magnifying-glass'],
        ['name' => 'Wireframing', 'icon' => 'pencil'],
        ['name' => 'Prototyping', 'icon' => 'sparkles'],
        ['name' => 'Visual Design', 'icon' => 'paint-brush'],
        ['name' => 'Design Systems', 'icon' => 'square-3-stack-3d'],
        ['name' => 'Usability Testing', 'icon' => 'eye'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden items-center gap-8 text-sm text-zinc-600 dark:text-zinc-400 md:flex">
                <a href="#work" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Work') }}</a>
                <a href="#process" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Process') }}</a>
                <a href="#about" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('About') }}</a>
                <a href="#contact" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Contact') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm" href="#contact">{{ __('Hire Me') }}</gsmui:button>
        </div>
    </header>

    <main>
        <section class="mx-auto max-w-6xl px-6 py-24">
            <gsmui:badge color="violet" class="mb-6">{{ __('Available for freelance') }}</gsmui:badge>
            <gsmui:heading size="xl" level="1" class="max-w-3xl">
                {{ $title }} — <span class="bg-gradient-to-r from-violet-500 to-pink-500 bg-clip-text text-transparent">{{ __('UI/UX Designer') }}</span>
            </gsmui:heading>
            <gsmui:text size="lg" variant="subtle" class="mt-4 max-w-2xl">{{ $subtitle }}</gsmui:text>
            <div class="mt-8 flex gap-3">
                <gsmui:button variant="primary" href="#work">{{ __('View Projects') }}</gsmui:button>
                <gsmui:button variant="outline" href="#contact">{{ __('Get in Touch') }}</gsmui:button>
            </div>
        </section>

        <section id="work" class="mx-auto max-w-6xl px-6 pb-24">
            <gsmui:heading size="lg" level="2" class="mb-2">{{ __('Selected Work') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mb-10">{{ __('A curated collection of recent projects.') }}</gsmui:text>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <gsmui:card variant="interactive" class="group overflow-hidden">
                        <x-slot:image>
                            <div class="{{ $project['color'] }} flex aspect-[4/3] items-center justify-center">
                                <gsmui:icon name="photo" variant="outline" class="h-12 w-12 text-white/50" />
                            </div>
                        </x-slot:image>
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <gsmui:text variant="strong">{{ $project['name'] }}</gsmui:text>
                                <gsmui:icon name="chevron-down" variant="outline" class="h-4 w-4 text-zinc-400 transition-transform group-hover:rotate-180" />
                            </div>
                            <gsmui:badge color="zinc" class="mt-3">{{ $project['category'] }}</gsmui:badge>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        </section>

        <section id="process" class="border-t border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-800/50 px-6 py-24">
            <div class="mx-auto max-w-6xl">
                <gsmui:heading size="lg" level="2" class="mb-2">{{ __('Skills & Expertise') }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mb-10">{{ __('Core competencies refined over years of practice.') }}</gsmui:text>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($skills as $skill)
                        <gsmui:card variant="default" size="sm">
                            <div class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-violet-100 dark:bg-violet-500/20">
                                    <gsmui:icon :name="$skill['icon']" variant="outline" class="h-5 w-5 text-violet-600 dark:text-violet-400" />
                                </div>
                                <gsmui:text variant="strong" size="sm">{{ $skill['name'] }}</gsmui:text>
                            </div>
                        </gsmui:card>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="contact" class="px-6 py-24 text-center">
            <div class="mx-auto max-w-xl">
                <gsmui:heading size="lg" level="2">{{ __("Let's create something amazing") }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mt-3">{{ __('Have a project in mind? I\'d love to hear about it.') }}</gsmui:text>
                <gsmui:button variant="primary" size="default" class="mt-8" href="mailto:hello@example.com">{{ __('Start a Conversation') }}</gsmui:button>
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-8 text-center text-sm text-zinc-500">
        &copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}
    </footer>
</div>
