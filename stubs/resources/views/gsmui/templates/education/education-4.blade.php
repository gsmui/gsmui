@props([
    'title' => 'TutorialHub',
    'subtitle' => __('Master new skills with step-by-step tutorials from industry experts.'),
    'tutorials' => [],
    'learning_path' => [],
])

@php
$tutorials = count($tutorials) ? $tutorials : [
    ['title' => 'Getting Started with Laravel', 'duration' => '45 min', 'level' => 'Beginner', 'desc' => 'Learn the basics of the Laravel PHP framework from scratch.', 'tags' => ['PHP', 'Laravel', 'Backend']],
    ['title' => 'Building Responsive Layouts with Tailwind', 'duration' => '30 min', 'level' => 'Intermediate', 'desc' => 'Create beautiful, responsive designs using Tailwind CSS utility classes.', 'tags' => ['CSS', 'Tailwind', 'Design']],
    ['title' => 'Introduction to TypeScript', 'duration' => '60 min', 'level' => 'Beginner', 'desc' => 'Add static typing to your JavaScript projects with TypeScript.', 'tags' => ['JavaScript', 'TypeScript']],
    ['title' => 'REST API Design Best Practices', 'duration' => '35 min', 'level' => 'Advanced', 'desc' => 'Design scalable and maintainable REST APIs that developers love.', 'tags' => ['API', 'Architecture']],
];
$learning_path = count($learning_path) ? $learning_path : [
    ['step' => 1, 'title' => 'Choose your path'],
    ['step' => 2, 'title' => 'Follow step-by-step tutorials'],
    ['step' => 3, 'title' => 'Build real projects'],
    ['step' => 4, 'title' => 'Earn your certificate'],
];
@endphp

<div {{ $attributes->class('bg-white dark:bg-zinc-900 min-h-screen') }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Tutorials') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Paths') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Community') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm">{{ __('Get Started') }}</gsmui:button>
        </div>
    </header>

    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">{{ $subtitle }}</p>
        <div class="mt-8">
            <gsmui:input type="search" :placeholder="__('Search tutorials...')" icon="magnifying-glass" />
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <gsmui:heading size="lg" level="2">{{ __('Your Learning Path') }}</gsmui:heading>
            </div>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($learning_path as $item)
                    <div class="relative flex flex-col items-center text-center">
                        <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400 font-bold text-lg">{{ $item['step'] }}</div>
                        <gsmui:text variant="strong" size="sm" class="mt-3">{{ $item['title'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <gsmui:heading size="lg" level="2">{{ __('Latest Tutorials') }}</gsmui:heading>
        <div class="mt-6 space-y-4">
            @foreach($tutorials as $tutorial)
                <gsmui:card variant="interactive">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <gsmui:text variant="strong">{{ $tutorial['title'] }}</gsmui:text>
                                <gsmui:badge color="amber" rounded>{{ $tutorial['level'] }}</gsmui:badge>
                            </div>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $tutorial['desc'] }}</p>
                            <div class="mt-2 flex items-center gap-2 flex-wrap">
                                @foreach($tutorial['tags'] as $tag)
                                    <gsmui:badge color="zinc" rounded>{{ $tag }}</gsmui:badge>
                                @endforeach
                                <span class="text-xs text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                    <gsmui:icon name="clock" class="w-3.5 h-3.5" /> {{ $tutorial['duration'] }}
                                </span>
                            </div>
                        </div>
                        <gsmui:button variant="outline" size="sm" href="#">{{ __('Start') }}</gsmui:button>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <gsmui:heading size="default" level="2">{{ __('Explore Categories') }}</gsmui:heading>
            <div class="mt-4 flex flex-wrap justify-center gap-3">
                @foreach(['Frontend', 'Backend', 'DevOps', 'Mobile', 'Database', 'Security'] as $cat)
                    <gsmui:button variant="outline" size="sm" href="#">{{ $cat }}</gsmui:button>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
