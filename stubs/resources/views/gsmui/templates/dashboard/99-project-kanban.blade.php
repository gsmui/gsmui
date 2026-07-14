<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Project Kanban</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-4 gap-4">
            @foreach([
                'Backlog' => ['Design login page', 'Write API docs'],
                'In Progress' => ['Build dashboard', 'Set up CI/CD'],
                'Review' => ['Update footer', 'Fix nav bug'],
                'Done' => ['Project setup', 'Wireframes'],
            ] as $column => $tasks)
            <div>
                <h3 class="text-sm font-medium text-zinc-500 mb-3">{{ $column }} ({{ count($tasks) }})</h3>
                <div class="space-y-2">
                    @foreach($tasks as $task)
                    <div class="bg-white dark:bg-zinc-800 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm">
                        <p class="text-sm text-zinc-900 dark:text-white">{{ $task }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </main>
</div>