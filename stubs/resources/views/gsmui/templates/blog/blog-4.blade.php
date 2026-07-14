@props([
    'title' => 'ByteStream',
    'subtitle' => __('Deep dives into software engineering, systems design, and developer culture.'),
    'posts' => [],
])

@php
$posts = count($posts) ? $posts : [
    ['title' => 'Building a Real-Time Event System with WebSockets', 'excerpt' => 'Architecture patterns for scalable real-time communication using WebSocket connections and event-driven backends.', 'author' => 'Alex Turner', 'date' => 'Jul 12, 2026', 'category' => 'Engineering', 'read_time' => '15 min'],
    ['title' => 'Rust for Systems Programmers: A Practical Guide', 'excerpt' => 'Why Rust is becoming the language of choice for performance-critical infrastructure.', 'author' => 'Priya Sharma', 'date' => 'Jul 10, 2026', 'category' => 'Languages', 'read_time' => '11 min'],
    ['title' => 'The Hidden Cost of Microservices', 'excerpt' => 'When distributed systems create more problems than they solve, and what to do about it.', 'author' => 'David Kim', 'date' => 'Jul 8, 2026', 'category' => 'Architecture', 'read_time' => '9 min'],
    ['title' => 'Kubernetes Security Best Practices for 2026', 'excerpt' => 'Hardening your K8s clusters with RBAC, network policies, and supply chain security.', 'author' => 'Marcus Lee', 'date' => 'Jul 6, 2026', 'category' => 'DevOps', 'read_time' => '13 min'],
    ['title' => 'AI-Assisted Code Review: Hype vs Reality', 'excerpt' => 'We tested AI code review tools for 6 months. Here\'s what actually works.', 'author' => 'Elena Rodriguez', 'date' => 'Jul 4, 2026', 'category' => 'AI', 'read_time' => '8 min'],
];
@endphp

<div {{ $attributes->class('bg-zinc-900 text-white min-h-screen') }}>
    <header class="border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden md:flex items-center gap-6">
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Articles') }}</a>
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Podcast') }}</a>
                <a href="#" class="text-sm text-zinc-400 hover:text-white">{{ __('Newsletter') }}</a>
            </nav>
            <gsmui:button variant="ghost" size="sm" icon="magnifying-glass" />
        </div>
    </header>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        <p class="mt-4 text-lg text-zinc-400 max-w-2xl mx-auto">{{ $subtitle }}</p>
        <div class="mt-8 max-w-md mx-auto flex gap-2">
            <gsmui:input type="email" :placeholder="__('developer@email.com')" icon="envelope" />
            <gsmui:button variant="primary" size="default">{{ __('Subscribe') }}</gsmui:button>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <gsmui:card variant="flat">
                    <div class="flex items-center gap-2 mb-3">
                        <gsmui:badge :color="$post['category'] === 'AI' ? 'cyan' : ($post['category'] === 'DevOps' ? 'green' : 'sky')" rounded>{{ $post['category'] }}</gsmui:badge>
                        <span class="text-xs text-zinc-500">{{ $post['read_time'] }} {{ __('read') }}</span>
                    </div>
                    <gsmui:text variant="strong" class="text-white">{{ $post['title'] }}</gsmui:text>
                    <p class="mt-2 text-sm text-zinc-400 line-clamp-3">{{ $post['excerpt'] }}</p>
                    <div class="mt-4 flex items-center gap-2">
                        <gsmui:avatar :name="$post['author']" size="sm" circle />
                        <div>
                            <p class="text-xs font-medium text-zinc-300">{{ $post['author'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $post['date'] }}</p>
                        </div>
                    </div>
                </gsmui:card>
            @endforeach
        </div>
    </section>

    <section class="border-t border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center gap-2">
                @foreach(['Engineering', 'Languages', 'Architecture', 'DevOps', 'AI', 'Security', 'Databases', 'Frontend'] as $tag)
                    <gsmui:badge color="zinc" rounded class="cursor-pointer">{{ $tag }}</gsmui:badge>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
