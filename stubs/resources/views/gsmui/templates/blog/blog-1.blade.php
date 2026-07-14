@props([
    'title' => 'The Daily Post',
    'subtitle' => __('Insights, stories, and ideas from our community of writers.'),
    'posts' => [],
    'featured' => null,
])

@php
$featured = $featured ?: ['title' => 'The Future of AI in Everyday Life', 'excerpt' => 'Artificial intelligence is no longer a distant concept — it\'s woven into our daily routines, from smart assistants to personalized recommendations.', 'author' => 'Elena Rodriguez', 'date' => 'Jul 12, 2026', 'category' => 'Technology'];
$posts = count($posts) ? $posts : [
    ['title' => 'Building Sustainable Cities for Tomorrow', 'excerpt' => 'Urban planners are reimagining cities with green infrastructure, renewable energy, and community-centered design.', 'author' => 'Marcus Lee', 'date' => 'Jul 10, 2026', 'category' => 'Environment', 'read_time' => '6 min'],
    ['title' => 'The Art of Mindful Productivity', 'excerpt' => 'How slowing down and being intentional with your time can actually help you accomplish more.', 'author' => 'Priya Sharma', 'date' => 'Jul 8, 2026', 'category' => 'Lifestyle', 'read_time' => '4 min'],
    ['title' => 'Remote Work: Three Years Later', 'excerpt' => 'A look at how distributed teams have evolved and what the data tells us about the future of work.', 'author' => 'David Kim', 'date' => 'Jul 6, 2026', 'category' => 'Business', 'read_time' => '8 min'],
    ['title' => 'Beginner\'s Guide to Home Cooking', 'excerpt' => 'Simple techniques and pantry staples that will transform your kitchen game.', 'author' => 'Amara Obi', 'date' => 'Jul 4, 2026', 'category' => 'Food', 'read_time' => '5 min'],
];
@endphp

<div {{ $attributes->class('bg-white dark:bg-zinc-900 min-h-screen') }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Latest') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Popular') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Categories') }}</a>
            </nav>
            <gsmui:button variant="ghost" size="sm" icon="magnifying-glass" />
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <gsmui:card variant="elevated" class="overflow-hidden">
            <div class="grid lg:grid-cols-2">
                <div class="bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 h-48 lg:h-auto flex items-center justify-center">
                    <gsmui:icon name="newspaper" class="w-16 h-16 text-indigo-300 dark:text-indigo-600" />
                </div>
                <div class="p-6 lg:p-8">
                    <gsmui:badge color="indigo" rounded>{{ $featured['category'] }}</gsmui:badge>
                    <gsmui:heading size="lg" level="2" class="mt-3">{{ $featured['title'] }}</gsmui:heading>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $featured['excerpt'] }}</p>
                    <div class="mt-4 flex items-center gap-3">
                        <gsmui:avatar :name="$featured['author']" size="sm" circle />
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $featured['author'] }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $featured['date'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </gsmui:card>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <gsmui:heading size="default" level="2">{{ __('Latest Posts') }}</gsmui:heading>
                @foreach($posts as $post)
                    <gsmui:card variant="interactive">
                        <div class="flex items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <gsmui:badge color="zinc" rounded>{{ $post['category'] }}</gsmui:badge>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $post['read_time'] }} {{ __('read') }}</span>
                                </div>
                                <gsmui:text variant="strong" class="mt-2">{{ $post['title'] }}</gsmui:text>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ $post['excerpt'] }}</p>
                                <div class="mt-3 flex items-center gap-2">
                                    <gsmui:avatar :name="$post['author']" size="sm" circle />
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $post['author'] }} · {{ $post['date'] }}</span>
                                </div>
                            </div>
                            <div class="hidden sm:block w-24 h-24 rounded-lg bg-zinc-100 dark:bg-zinc-800 shrink-0 flex items-center justify-center">
                                <gsmui:icon name="photo" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                            </div>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>

            <aside class="space-y-6">
                <div>
                    <gsmui:heading size="default" level="3">{{ __('Categories') }}</gsmui:heading>
                    <div class="mt-3 space-y-2">
                        @foreach(['Technology', 'Environment', 'Lifestyle', 'Business', 'Food', 'Health'] as $cat)
                            <a href="#" class="flex items-center justify-between p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $cat }}
                                <gsmui:icon name="chevron-down" class="w-4 h-4 rotate-[-90deg]" />
                            </a>
                        @endforeach
                    </div>
                </div>
                <gsmui:divider />
                <div>
                    <gsmui:heading size="default" level="3">{{ __('Popular Posts') }}</gsmui:heading>
                    <div class="mt-3 space-y-3">
                        @foreach(array_slice($posts, 0, 3) as $post)
                            <a href="#" class="block">
                                <gsmui:text variant="strong" size="sm">{{ $post['title'] }}</gsmui:text>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $post['date'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
