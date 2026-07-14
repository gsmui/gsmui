<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Team Workspace</h1>
            <div class="flex items-center gap-2">
                <span class="flex items-center gap-1.5 px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs rounded-full">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> 5 online
                </span>
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Project: Website Redesign</h2>
                    <div class="flex -space-x-2">
                        @foreach(['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-amber-500', 'bg-pink-500'] as $color)
                        <div class="w-8 h-8 rounded-full {{ $color }} border-2 border-white dark:border-zinc-800"></div>
                        @endforeach
                    </div>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['To Do' => ['Design mockups', 'Write copy'], 'In Progress' => ['Frontend dev', 'API integration'], 'Done' => ['Wireframes', 'Research'] ] as $column => $tasks)
                        <div class="bg-zinc-50 dark:bg-zinc-700/30 rounded-lg p-3">
                            <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">{{ $column }}</h3>
                            <div class="space-y-2">
                                @foreach($tasks as $task)
                                <div class="bg-white dark:bg-zinc-800 p-2 rounded shadow-sm border border-zinc-200 dark:border-zinc-600 text-sm text-zinc-700 dark:text-zinc-300">
                                    {{ $task }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Activity Feed</h2>
                <div class="space-y-3">
                    @foreach([
                        ['user' => 'Alex', 'action' => 'moved "API integration" to In Progress', 'time' => '2m ago', 'color' => 'bg-blue-500'],
                        ['user' => 'Sarah', 'action' => 'commented on "Design mockups"', 'time' => '5m ago', 'color' => 'bg-green-500'],
                        ['user' => 'Mike', 'action' => 'completed "Wireframes"', 'time' => '1h ago', 'color' => 'bg-purple-500'],
                    ] as $activity)
                    <div class="flex items-start gap-2">
                        <div class="w-6 h-6 rounded-full {{ $activity['color'] }} flex-shrink-0"></div>
                        <div>
                            <p class="text-sm text-zinc-700 dark:text-zinc-300"><span class="font-medium">{{ $activity['user'] }}</span> {{ $activity['action'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
