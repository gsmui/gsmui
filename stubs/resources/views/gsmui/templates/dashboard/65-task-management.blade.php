<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Task Manager</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Add Task</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $priorityColorMap = [
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'To Do', 'value' => '12', 'color' => 'text-zinc-600'],
                ['label' => 'In Progress', 'value' => '8', 'color' => 'text-blue-600'],
                ['label' => 'In Review', 'value' => '4', 'color' => 'text-purple-600'],
                ['label' => 'Done', 'value' => '34', 'color' => 'text-green-600'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            @foreach([
                'To Do' => [['title' => 'Design login page', 'assignee' => 'Alex', 'priority' => 'High', 'color' => 'red'], ['title' => 'Write API docs', 'assignee' => 'Sarah', 'priority' => 'Medium', 'color' => 'yellow']],
                'In Progress' => [['title' => 'Build dashboard', 'assignee' => 'Mike', 'priority' => 'High', 'color' => 'red'], ['title' => 'Set up CI/CD', 'assignee' => 'Alex', 'priority' => 'Low', 'color' => 'blue']],
                'In Review' => [['title' => 'Update footer', 'assignee' => 'Sarah', 'priority' => 'Low', 'color' => 'blue']],
                'Done' => [['title' => 'Project setup', 'assignee' => 'Mike', 'priority' => 'Medium', 'color' => 'yellow']],
            ] as $column => $tasks)
            <div class="bg-zinc-100 dark:bg-zinc-800 rounded-xl p-3">
                <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">{{ $column }}</h3>
                <div class="space-y-2">
                    @foreach($tasks as $task)
                    <div class="bg-white dark:bg-zinc-700 p-3 rounded-lg shadow-sm border border-zinc-200 dark:border-zinc-600">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $task['title'] }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xs text-zinc-500">{{ $task['assignee'] }}</span>
                            <span class="px-1.5 py-0.5 text-[10px] rounded {{ $priorityColorMap[$task['color']]['bg'] }} {{ $priorityColorMap[$task['color']]['text'] }}">{{ $task['priority'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </main>
</div>
