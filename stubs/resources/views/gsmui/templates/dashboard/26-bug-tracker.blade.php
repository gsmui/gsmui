<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Bug Tracker</h1>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium">+ Report Bug</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
            'zinc' => ['bg' => 'bg-zinc-100 dark:bg-zinc-900/30', 'text' => 'text-zinc-800 dark:text-zinc-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Open', 'value' => '23', 'color' => 'text-red-600'],
                ['label' => 'In Progress', 'value' => '15', 'color' => 'text-yellow-600'],
                ['label' => 'Resolved', 'value' => '89', 'color' => 'text-green-600'],
                ['label' => 'Closed', 'value' => '234', 'color' => 'text-zinc-600'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Recent Bugs</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['id' => '#1234', 'title' => 'Login fails on Safari', 'priority' => 'High', 'color' => 'red', 'assignee' => 'John D.'],
                    ['id' => '#1233', 'title' => 'Dashboard slow on mobile', 'priority' => 'Medium', 'color' => 'yellow', 'assignee' => 'Sarah M.'],
                    ['id' => '#1232', 'title' => 'Email notification delay', 'priority' => 'Low', 'color' => 'blue', 'assignee' => 'Mike R.'],
                ] as $bug)
                <div class="p-4 flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                    <span class="font-mono text-sm text-zinc-500">{{ $bug['id'] }}</span>
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $bug['title'] }}</p>
                        <p class="text-sm text-zinc-500">Assigned to {{ $bug['assignee'] }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColors[$bug['color']]['bg'] }} {{ $badgeColors[$bug['color']]['text'] }}">{{ $bug['priority'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
