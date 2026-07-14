<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Project Tracker</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ New Project</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $statColors = [
            'blue' => 'text-blue-600',
            'green' => 'text-green-600',
            'yellow' => 'text-yellow-600',
            'zinc' => 'text-zinc-600',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Active Projects', 'value' => '12', 'color' => 'blue'],
                ['label' => 'On Track', 'value' => '9', 'color' => 'green'],
                ['label' => 'At Risk', 'value' => '2', 'color' => 'yellow'],
                ['label' => 'Completed', 'value' => '34', 'color' => 'zinc'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $statColors[$stat['color']] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Active Projects</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Website Redesign', 'progress' => 72, 'team' => 5, 'deadline' => 'Jul 30'],
                        ['name' => 'Mobile App v2', 'progress' => 45, 'team' => 8, 'deadline' => 'Aug 15'],
                        ['name' => 'API Migration', 'progress' => 88, 'team' => 3, 'deadline' => 'Jun 30'],
                    ] as $project)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $project['name'] }}</span>
                            <span class="text-xs text-zinc-500">{{ $project['deadline'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-1 h-2 bg-zinc-200 dark:bg-zinc-600 rounded-full">
                                <div class="h-full bg-blue-500 rounded-full" style="width: {{ $project['progress'] }}%"></div>
                            </div>
                            <span class="text-xs text-zinc-500">{{ $project['progress'] }}%</span>
                            <span class="text-xs text-zinc-500">{{ $project['team'] }} members</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Upcoming Deadlines</h2>
                <div class="space-y-3">
                    @foreach([
                        ['task' => 'API Migration - Phase 2', 'project' => 'API Migration', 'due' => 'Jun 28', 'urgent' => true],
                        ['task' => 'Design Review', 'project' => 'Website Redesign', 'due' => 'Jul 5', 'urgent' => false],
                        ['task' => 'Beta Release', 'project' => 'Mobile App v2', 'due' => 'Jul 15', 'urgent' => false],
                    ] as $deadline)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-2 h-2 rounded-full {{ $deadline['urgent'] ? 'bg-red-500' : 'bg-blue-500' }}"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $deadline['task'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $deadline['project'] }}</p>
                        </div>
                        <span class="text-xs font-medium {{ $deadline['urgent'] ? 'text-red-600' : 'text-zinc-500' }}">{{ $deadline['due'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
