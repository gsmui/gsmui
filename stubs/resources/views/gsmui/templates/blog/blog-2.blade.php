@props([
    'title' => 'Pulse Magazine',
    'subtitle' => __('Your daily dose of culture, tech, and lifestyle.'),
    'categories' => [],
    'posts' => [],
])

@php
$categories = count($categories) ? $categories : ['All', 'Technology', 'Culture', 'Design', 'Science', 'Travel', 'Food'];
$posts = count($posts) ? $posts : [
    ['title' => 'How Quantum Computing Will Change Everything', 'excerpt' => 'From drug discovery to cryptography, quantum computers are poised to revolutionize entire industries.', 'author' => 'Elena Rodriguez', 'date' => 'Jul 12, 2026', 'category' => 'Technology', 'read_time' => '12 min'],
    ['title' => 'The Rise of Slow Fashion', 'excerpt' => 'Consumers are ditching fast fashion for sustainable, timeless wardrobe choices.', 'author' => 'Amara Obi', 'date' => 'Jul 11, 2026', 'category' => 'Culture', 'read_time' => '7 min'],
    ['title' => 'Designing for Accessibility', 'excerpt' => 'Why inclusive design isn\'t just good ethics — it\'s good business.', 'author' => 'Marcus Lee', 'date' => 'Jul 10, 2026', 'category' => 'Design', 'read_time' => '9 min'],
    ['title' => 'Deep Ocean Mysteries Revealed', 'excerpt' => 'New submersible technology is uncovering species never seen before.', 'author' => 'David Kim', 'date' => 'Jul 9, 2026', 'category' => 'Science', 'read_time' => '6 min'],
    ['title' => 'Tokyo\'s Hidden Food Scene', 'excerpt' => 'Beyond sushi and ramen — exploring the city\'s underground culinary gems.', 'author' => 'Priya Sharma', 'date' => 'Jul 8, 2026', 'category' => 'Food', 'read_time' => '8 min'],
    ['title' => 'Remote Work Destinations for 2026', 'excerpt' => 'The best cities for digital nomads this year, ranked.', 'author' => 'James Wilson', 'date' => 'Jul 7, 2026', 'category' => 'Travel', 'read_time' => '5 min'],
];
@endphp

<div {{ $attributes->class('bg-white dark:bg-zinc-900 min-h-screen') }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Trending') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Editors\' Pick') }}</a>
            </nav>
            <gsmui:button variant="primary" size="sm">{{ __('Subscribe') }}</gsmui:button>
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid lg:grid-cols-2 gap-6">
            <gsmui:card variant="elevated" class="overflow-hidden">
                <div class="bg-gradient-to-br from-violet-100 to-pink-100 dark:from-violet-900/30 dark:to-pink-900/30 h-48 lg:h-64 flex items-center justify-center">
                    <gsmui:icon name="sparkles" class="w-16 h-16 text-violet-300 dark:text-violet-600" />
                </div>
                <div class="p-6">
                    <gsmui:badge color="violet" rounded>{{ $posts[0]['category'] }}</gsmui:badge>
                    <gsmui:heading size="lg" level="2" class="mt-2">{{ $posts[0]['title'] }}</gsmui:heading>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $posts[0]['excerpt'] }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <gsmui:avatar :name="$posts[0]['author']" size="sm" circle />
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $posts[0]['author'] }} · {{ $posts[0]['read_time'] }} {{ __('read') }}</span>
                    </div>
                </div>
            </gsmui:card>
            <div class="grid gap-6">
                @foreach(array_slice($posts, 1, 2) as $post)
                    <gsmui:card variant="elevated">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <gsmui:badge color="pink" rounded>{{ $post['category'] }}</gsmui:badge>
                                <gsmui:text variant="strong" class="mt-2">{{ $post['title'] }}</gsmui:text>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">{{ $post['excerpt'] }}</p>
                                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ $post['author'] }} · {{ $post['read_time'] }} {{ __('read') }}</p>
                            </div>
                            <div class="w-20 h-20 rounded-lg bg-zinc-100 dark:bg-zinc-800 shrink-0 flex items-center justify-center">
                                <gsmui:icon name="photo" class="w-6 h-6 text-zinc-300 dark:text-zinc-600" />
                            </div>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-2 overflow-x-auto pb-2">
            @foreach($categories as $cat)
                <gsmui:badge :color="$loop->first ? 'violet' : 'zinc'" rounded class="cursor-pointer">{{ $cat }}</gsmui:badge>
            @endforeach
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(array_slice($posts, 3) as $post)
                <gsmui:card variant="interactive">
                    <x-slot:image>
                        <div class="h-40 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 flex items-center justify-center">
                            <gsmui:icon name="photo" class="w-8 h-8 text-zinc-300 dark:text-zinc-600" />
                        </div>
                    </x-slot:image>
                    <gsmui:badge color="cyan" rounded>{{ $post['category'] }}</gsmui:badge>
                    <gsmui:text variant="strong" size="sm" class="mt-2">{{ $post['title'] }}</gsmui:text>
                    <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400 line-clamp-2">{{ $post['excerpt'] }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <gsmui:avatar :name="$post['author']" size="sm" circle />
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $post['author'] }} · {{ $post['read_time'] }}</span>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-12">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <gsmui:heading size="default" level="2">{{ __('Stay in the Loop') }}</gsmui:heading>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Get the best stories delivered to your inbox every week.') }}</p>
            <div class="mt-4 flex gap-2">
                <gsmui:input type="email" :placeholder="__('your@email.com')" icon="envelope" />
                <gsmui:button variant="primary" size="default">{{ __('Subscribe') }}</gsmui:button>
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
