@extends('gsmui::layouts.demo')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Learning Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Enrolled Courses</p>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-1">12</p>
                <div class="mt-3 h-2 bg-zinc-100 dark:bg-zinc-700 rounded-full">
                    <div class="h-2 bg-blue-500 rounded-full" style="width: 65%"></div>
                </div>
                <p class="text-xs text-zinc-500 mt-2">65% complete</p>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Hours Learned</p>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-1">84</p>
                <span class="text-sm text-green-500">+12 this week</span>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Certificates</p>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-1">3</p>
                <span class="text-sm text-purple-500">1 pending</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Continue Learning</h3>
                <div class="space-y-4">
                    @foreach([
                        ['title' => 'Advanced Laravel', 'progress' => 75, 'category' => 'Development'],
                        ['title' => 'UI/UX Design Fundamentals', 'progress' => 45, 'category' => 'Design'],
                        ['title' => 'Data Science Basics', 'progress' => 30, 'category' => 'Data'],
                    ] as $course)
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded">{{ $course['category'] }}</span>
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $course['progress'] }}%</span>
                            </div>
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $course['title'] }}</p>
                            <div class="mt-2 h-1.5 bg-zinc-200 dark:bg-zinc-600 rounded-full">
                                <div class="h-1.5 bg-blue-500 rounded-full" style="width: {{ $course['progress'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Recommended</h3>
                <div class="space-y-4">
                    @foreach([
                        ['title' => 'React Masterclass', 'instructor' => 'John Smith', 'rating' => '4.8', 'price' => '$49'],
                        ['title' => 'Python for Beginners', 'instructor' => 'Jane Doe', 'rating' => '4.9', 'price' => '$39'],
                    ] as $course)
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $course['title'] }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">by {{ $course['instructor'] }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm text-yellow-500">⭐ {{ $course['rating'] }}</span>
                                <span class="font-semibold text-zinc-900 dark:text-white">{{ $course['price'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
