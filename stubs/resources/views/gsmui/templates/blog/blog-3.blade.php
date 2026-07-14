@props([
    'title' => 'DevBlog',
    'posts' => [],
    'recent' => [],
    'tags' => [],
])

@php
$posts = count($posts) ? $posts : [
    ['title' => 'Understanding Laravel\'s Service Container', 'excerpt' => 'A deep dive into dependency injection and how Laravel\'s IoC container works under the hood.', 'author' => 'Sarah Johnson', 'date' => 'Jul 12, 2026', 'tags' => ['PHP', 'Laravel', 'Architecture']],
    ['title' => 'CSS Grid vs Flexbox: When to Use Which', 'excerpt' => 'A practical guide to choosing the right layout system for your next project.', 'author' => 'Marcus Lee', 'date' => 'Jul 10, 2026', 'tags' => ['CSS', 'Frontend']],
    ['title' => 'Deploying with Docker Compose', 'excerpt' => 'Step-by-step guide to containerizing and deploying your application using Docker Compose.', 'author' => 'David Kim', 'date' => 'Jul 8, 2026', 'tags' => ['Docker', 'DevOps']],
];
$recent = count($recent) ? $recent : [
    ['title' => 'API Rate Limiting Strategies', 'date' => 'Jul 6, 2026'],
    ['title' => 'Getting Started with Livewire Volt', 'date' => 'Jul 4, 2026'],
    ['title' => 'Tailwind CSS v4 Migration Guide', 'date' => 'Jul 2, 2026'],
];
$tags = count($tags) ? $tags : ['PHP', 'Laravel', 'JavaScript', 'CSS', 'Docker', 'DevOps', 'API', 'Testing', 'Livewire', 'Tailwind', 'Vue', 'React'];
@endphp

<div {{ $attributes->class('bg-white dark:bg-zinc-900 min-h-screen') }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <gsmui:button variant="ghost" size="sm" icon="magnifying-glass" />
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid lg:grid-cols-3 gap-8">
            <main class="lg:col-span-2 space-y-6">
                @foreach($posts as $post)
                    <gsmui:card variant="interactive">
                        <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                            <gsmui:avatar :name="$post['author']" size="sm" circle />
                            <span>{{ $post['author'] }}</span>
                            <span>·</span>
                            <span>{{ $post['date'] }}</span>
                        </div>
                        <gsmui:text variant="strong" class="mt-3">{{ $post['title'] }}</gsmui:text>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $post['excerpt'] }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($post['tags'] as $tag)
                                <gsmui:badge color="zinc" rounded>{{ $tag }}</gsmui:badge>
                            @endforeach
                        </div>
                        <gsmui:button variant="ghost" size="sm" class="mt-3" href="#">{{ __('Read more') }} →</gsmui:button>
                    </gsmui:card>
                @endforeach
            </main>

            <aside class="space-y-6">
                <div>
                    <gsmui:input type="search" :placeholder="__('Search posts...')" icon="magnifying-glass" />
                </div>

                <gsmui:divider />

                <div>
                    <gsmui:heading size="default" level="3">{{ __('Recent Posts') }}</gsmui:heading>
                    <div class="mt-3 space-y-3">
                        @foreach($recent as $item)
                            <a href="#" class="block group">
                                <gsmui:text variant="strong" size="sm" class="group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ $item['title'] }}</gsmui:text>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $item['date'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <gsmui:divider />

                <div>
                    <gsmui:heading size="default" level="3">{{ __('Tags') }}</gsmui:heading>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <gsmui:badge color="zinc" rounded class="cursor-pointer">{{ $tag }}</gsmui:badge>
                        @endforeach
                    </div>
                </div>

                <gsmui:divider />

                <div>
                    <gsmui:heading size="default" level="3">{{ __('Newsletter') }}</gsmui:heading>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Get weekly dev tips straight to your inbox.') }}</p>
                    <div class="mt-3 space-y-2">
                        <gsmui:input type="email" :placeholder="__('your@email.com')" icon="envelope" />
                        <gsmui:button variant="primary" size="sm" class="w-full">{{ __('Subscribe') }}</gsmui:button>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
