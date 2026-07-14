<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Feedback Portal</h1>
    </header>
    <main class="p-6">
        @php
        $badgeColors = [
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'purple' => ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-800 dark:text-purple-400'],
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Total Feedback' => '342', 'Open' => '47', 'Planned' => '23', 'Completed' => '89'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Top Requests</h2>
            <div class="space-y-3">
                @foreach([
                    ['title' => 'Dark mode support', 'votes' => 234, 'status' => 'Planned', 'color' => 'blue'],
                    ['title' => 'Mobile app', 'votes' => 189, 'status' => 'Open', 'color' => 'yellow'],
                    ['title' => 'API access', 'votes' => 156, 'status' => 'In Progress', 'color' => 'purple'],
                    ['title' => 'Export to PDF', 'votes' => 123, 'status' => 'Completed', 'color' => 'green'],
                ] as $feedback)
                <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <div class="w-10 text-center">
                        <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $feedback['votes'] }}</p>
                        <p class="text-[10px] text-zinc-500">votes</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $feedback['title'] }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$feedback['color']]['bg'] }} {{ $badgeColors[$feedback['color']]['text'] }}">{{ $feedback['status'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
