<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Learning Dashboard</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Create Course</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $indicatorColors = [
            'blue' => 'bg-blue-500',
            'purple' => 'bg-purple-500',
            'amber' => 'bg-amber-500',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Enrolled Students', 'value' => '2,340'],
                ['label' => 'Active Courses', 'value' => '18'],
                ['label' => 'Completion Rate', 'value' => '87%'],
                ['label' => 'Avg Score', 'value' => '82%'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">My Courses</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Laravel Advanced', 'progress' => 75, 'color' => 'blue'],
                        ['name' => 'React Fundamentals', 'progress' => 45, 'color' => 'purple'],
                        ['name' => 'AWS Certification', 'progress' => 20, 'color' => 'amber'],
                    ] as $course)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-zinc-900 dark:text-white">{{ $course['name'] }}</span>
                            <span class="text-xs text-zinc-500">{{ $course['progress'] }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-600 rounded-full">
                            <div class="h-full {{ $indicatorColors[$course['color']] }} rounded-full" style="width: {{ $course['progress'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Upcoming Deadlines</h2>
                <div class="space-y-3">
                    @foreach([
                        ['task' => 'Assignment 3', 'course' => 'Laravel Advanced', 'due' => 'Tomorrow'],
                        ['task' => 'Quiz 2', 'course' => 'React Fundamentals', 'due' => 'In 3 days'],
                        ['task' => 'Project Submission', 'course' => 'AWS Certification', 'due' => 'Next week'],
                    ] as $item)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $item['task'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $item['course'] }}</p>
                        </div>
                        <span class="text-xs text-orange-600 font-medium">{{ $item['due'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
