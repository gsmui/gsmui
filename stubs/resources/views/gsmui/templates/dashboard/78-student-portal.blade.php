<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Student Portal</h1>
    </header>

    <main class="p-6">
        @php
        $gradeColorMap = [
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
        ];
        @endphp
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 mb-6 text-white">
            <h2 class="text-2xl font-bold">Welcome back, Alex!</h2>
            <p class="text-white/80 mt-1">Fall semester starts in 45 days</p>
            <div class="flex items-center gap-6 mt-4">
                <div><p class="text-3xl font-bold">3.8</p><p class="text-white/70 text-sm">GPA</p></div>
                <div><p class="text-3xl font-bold">12</p><p class="text-white/70 text-sm">Credits</p></div>
                <div><p class="text-3xl font-bold">89%</p><p class="text-white/70 text-sm">Attendance</p></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Current Courses</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Advanced Web Development', 'prof' => 'Dr. Smith', 'grade' => 'A', 'color' => 'green'],
                        ['name' => 'Database Systems', 'prof' => 'Prof. Johnson', 'grade' => 'B+', 'color' => 'blue'],
                        ['name' => 'Machine Learning', 'prof' => 'Dr. Chen', 'grade' => 'A-', 'color' => 'green'],
                    ] as $course)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-lg">📚</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $course['name'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $course['prof'] }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-bold rounded {{ $gradeColorMap[$course['color']]['bg'] }} {{ $gradeColorMap[$course['color']]['text'] }}">{{ $course['grade'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Upcoming Assignments</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Final Project', 'course' => 'Web Dev', 'due' => 'Jul 15', 'urgent' => true],
                        ['name' => 'Lab Report 5', 'course' => 'ML', 'due' => 'Jul 20', 'urgent' => false],
                        ['name' => 'Quiz 3', 'course' => 'DB Systems', 'due' => 'Jul 25', 'urgent' => false],
                    ] as $assignment)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-2 h-2 rounded-full {{ $assignment['urgent'] ? 'bg-red-500' : 'bg-blue-500' }}"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $assignment['name'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $assignment['course'] }}</p>
                        </div>
                        <span class="text-xs font-medium {{ $assignment['urgent'] ? 'text-red-600' : 'text-zinc-500' }}">{{ $assignment['due'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
