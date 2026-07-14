@props([
    'title' => 'My Learning',
    'courses' => [],
    'stats' => [],
    'upcoming' => [],
])

@php
$courses = count($courses) ? $courses : [
    ['title' => 'Advanced React Patterns', 'progress' => 68, 'next_lesson' => 'Custom Hooks Deep Dive', 'instructor' => 'Sarah Johnson'],
    ['title' => 'Python for Data Science', 'progress' => 42, 'next_lesson' => 'Pandas DataFrames', 'instructor' => 'Michael Chen'],
    ['title' => 'UI/UX Design Principles', 'progress' => 85, 'next_lesson' => 'Accessibility Testing', 'instructor' => 'Emily Rivera'],
];
$stats = count($stats) ? $stats : [
    ['label' => 'Courses Enrolled', 'value' => '12', 'icon' => 'academic-cap'],
    ['label' => 'Hours Learned', 'value' => '86', 'icon' => 'clock'],
    ['label' => 'Certificates', 'value' => '5', 'icon' => 'trophy'],
    ['label' => 'Streak', 'value' => '14 days', 'icon' => 'sparkles'],
];
$upcoming = count($upcoming) ? $upcoming : [
    ['title' => 'Live Q&A: React Patterns', 'date' => 'Jul 15, 2026', 'time' => '2:00 PM'],
    ['title' => 'Python Study Group', 'date' => 'Jul 17, 2026', 'time' => '10:00 AM'],
    ['title' => 'Design Portfolio Review', 'date' => 'Jul 20, 2026', 'time' => '3:30 PM'],
];
@endphp

<div {{ $attributes->class('bg-zinc-50 dark:bg-zinc-950 min-h-screen') }}>
    <header class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <div class="flex items-center gap-3">
                <gsmui:input type="search" :placeholder="__('Search...')" icon="magnifying-glass" />
                <gsmui:avatar name="John Doe" size="sm" circle />
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex gap-8">
        <aside class="hidden lg:block w-56 shrink-0">
            <nav class="space-y-1">
                @foreach(['Dashboard', 'My Courses', 'Schedule', 'Certificates', 'Settings'] as $item)
                    <a href="#" @class([
                        'flex items-center gap-3 px-3 py-2 rounded-lg text-sm',
                        'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 font-medium' => $loop->first,
                        'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' => !$loop->first,
                    ])>
                        @if($loop->first)
                            <gsmui:icon name="chart-bar" class="w-5 h-5" />
                        @else
                            <gsmui:icon name="document" class="w-5 h-5" />
                        @endif
                        {{ __($item) }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <main class="flex-1 min-w-0">
            <gsmui:heading size="lg" level="1">{{ __('Welcome back!') }}</gsmui:heading>

            <div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($stats as $stat)
                    <gsmui:card>
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                                <gsmui:icon :name="$stat['icon']" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-zinc-900 dark:text-white tabular-nums">{{ $stat['value'] }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                            </div>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>

            <div class="mt-8">
                <gsmui:heading size="default" level="2">{{ __('In Progress') }}</gsmui:heading>
                <div class="mt-4 space-y-4">
                    @foreach($courses as $course)
                        <gsmui:card variant="interactive">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                <div class="flex-1 min-w-0">
                                    <gsmui:text variant="strong">{{ $course['title'] }}</gsmui:text>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('by') }} {{ $course['instructor'] }}</p>
                                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ __('Next:') }} {{ $course['next_lesson'] }}</p>
                                    <div class="mt-3">
                                        <gsmui:progress :value="$course['progress']" color="indigo" :label="$course['progress'] . '%'" />
                                    </div>
                                </div>
                                <gsmui:button variant="primary" size="sm">{{ __('Continue') }}</gsmui:button>
                            </div>
                        </gsmui:card>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                <gsmui:heading size="default" level="2">{{ __('Upcoming') }}</gsmui:heading>
                <div class="mt-4 space-y-3">
                    @foreach($upcoming as $event)
                        <div class="flex items-center gap-4 p-3 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800">
                            <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-900/30">
                                <gsmui:icon name="calendar" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                            </div>
                            <div class="flex-1">
                                <gsmui:text variant="strong" size="sm">{{ $event['title'] }}</gsmui:text>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $event['date'] }} · {{ $event['time'] }}</p>
                            </div>
                            <gsmui:button variant="ghost" size="xs">{{ __('Join') }}</gsmui:button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                <gsmui:heading size="default" level="2">{{ __('Quick Actions') }}</gsmui:heading>
                <div class="mt-4 flex flex-wrap gap-3">
                    <gsmui:button variant="outline" size="sm" icon="magnifying-glass" href="#">{{ __('Browse Courses') }}</gsmui:button>
                    <gsmui:button variant="outline" size="sm" icon="bookmark" href="#">{{ __('My Bookmarks') }}</gsmui:button>
                    <gsmui:button variant="outline" size="sm" icon="trophy" href="#">{{ __('View Certificates') }}</gsmui:button>
                </div>
            </div>
        </main>
    </div>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-6 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <gsmui:brand :name="$title" href="#" />
            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('© :year :title. All rights reserved.', ['year' => date('Y'), 'title' => $title]) }}</p>
        </div>
    </footer>
</div>
