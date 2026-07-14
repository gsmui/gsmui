@props([
    'title' => 'Lens & Letter',
    'subtitle' => __('Visual storytelling meets thoughtful commentary.'),
    'posts' => [],
])

@php
$posts = count($posts) ? $posts : [
    ['title' => 'The Vanishing Glaciers of Patagonia', 'excerpt' => 'A photographic journey through one of Earth\'s last wild frontiers, documenting the retreat of ancient ice.', 'author' => 'Sofia Mendez', 'date' => 'Jul 12, 2026', 'category' => 'Environment'],
    ['title' => 'Street Art After Dark', 'excerpt' => 'How neon lights and spray paint are transforming abandoned neighborhoods into open-air galleries.', 'author' => 'Kai Nakamura', 'date' => 'Jul 10, 2026', 'category' => 'Culture'],
    ['title' => 'The Quiet Architecture of Japan', 'excerpt' => 'Exploring the understated beauty of Japanese minimalism through the lens of modern architecture.', 'author' => 'Amara Obi', 'date' => 'Jul 8, 2026', 'category' => 'Architecture'],
    ['title' => 'Farm to Table: A Visual Essay', 'excerpt' => 'Following the journey of food from soil to plate across three continents.', 'author' => 'James Wilson', 'date' => 'Jul 6, 2026', 'category' => 'Food'],
];
@endphp

<div {{ $attributes->class('bg-white dark:bg-zinc-900 min-h-screen') }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Stories') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('Photography') }}</a>
                <a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">{{ __('About') }}</a>
            </nav>
            <gsmui:button variant="outline" size="sm">{{ __('Subscribe') }}</gsmui:button>
        </div>
    </header>

    <section class="relative">
        <div class="bg-gradient-to-br from-zinc-200 to-zinc-300 dark:from-zinc-800 dark:to-zinc-700 h-72 sm:h-96 flex items-center justify-center">
            <gsmui:icon name="photo" class="w-20 h-20 text-zinc-400 dark:text-zinc-500" />
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
                <gsmui:badge color="rose" rounded>{{ $posts[0]['category'] }}</gsmui:badge>
                <gsmui:heading size="xl" level="1" class="mt-2 text-white">{{ $posts[0]['title'] }}</gsmui:heading>
                <p class="mt-2 text-sm text-zinc-200 max-w-xl">{{ $posts[0]['excerpt'] }}</p>
                <div class="mt-3 flex items-center gap-2">
                    <gsmui:avatar :name="$posts[0]['author']" size="sm" circle />
                    <span class="text-xs text-zinc-300">{{ $posts[0]['author'] }} · {{ $posts[0]['date'] }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            @foreach(array_slice($posts, 1) as $post)
                <gsmui:card variant="interactive" class="overflow-hidden">
                    <x-slot:image>
                        <div class="h-56 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 flex items-center justify-center">
                            <gsmui:icon name="photo" class="w-12 h-12 text-zinc-300 dark:text-zinc-600" />
                        </div>
                    </x-slot:image>
                    <gsmui:badge color="rose" rounded>{{ $post['category'] }}</gsmui:badge>
                    <gsmui:text variant="strong" class="mt-2">{{ $post['title'] }}</gsmui:text>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $post['excerpt'] }}</p>
                    <div class="mt-4 flex items-center gap-2">
                        <gsmui:avatar :name="$post['author']" size="sm" circle />
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ $post['author'] }} · {{ $post['date'] }}</span>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="bg-zinc-50 dark:bg-zinc-800/50 py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <gsmui:heading size="lg" level="2">{{ __('About :title', ['title' => $title]) }}</gsmui:heading>
            <p class="mt-4 text-zinc-600 dark:text-zinc-400">{{ __('We believe every image tells a story. :title is a curated space for photographers, writers, and visual artists to share narratives that move, inspire, and provoke thought.', ['title' => $title]) }}</p>
            <div class="mt-6 flex items-center justify-center gap-4">
                <gsmui:button variant="outline" href="#">{{ __('Meet the Team') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#">{{ __('Submit a Story') }}</gsmui:button>
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
