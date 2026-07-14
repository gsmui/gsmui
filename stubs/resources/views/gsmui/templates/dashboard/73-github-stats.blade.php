<div class="min-h-screen bg-zinc-900">
    <header class="bg-zinc-800 border-b border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-white">GitHub Dashboard</h1>
    </header>

    <main class="p-6">
        @php
        $dotColors = [
            'green' => 'bg-green-500',
            'yellow' => 'bg-yellow-500',
            'red' => 'bg-red-500',
            'zinc' => 'bg-zinc-500',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Stars', 'value' => '12.4K', 'icon' => '⭐'],
                ['label' => 'Forks', 'value' => '2.1K', 'icon' => '🍴'],
                ['label' => 'Open Issues', 'value' => '47', 'icon' => '🐛'],
                ['label' => 'Contributors', 'value' => '89', 'icon' => '👥'],
            ] as $stat)
            <div class="bg-zinc-800 rounded-xl p-4 border border-zinc-700">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $stat['icon'] }}</span>
                    <div>
                        <p class="text-sm text-zinc-400">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-white">{{ $stat['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Recent Commits</h2>
                <div class="space-y-3">
                    @foreach([
                        ['message' => 'feat: add new component API', 'author' => 'Alex', 'time' => '2h ago', 'sha' => 'a1b2c3d'],
                        ['message' => 'fix: resolve memory leak', 'author' => 'Sarah', 'time' => '5h ago', 'sha' => 'e4f5g6h'],
                        ['message' => 'docs: update README', 'author' => 'Mike', 'time' => '1d ago', 'sha' => 'i7j8k9l'],
                    ] as $commit)
                    <div class="flex items-center gap-3 p-3 bg-zinc-700/50 rounded-lg">
                        <code class="text-xs text-zinc-500 font-mono">{{ $commit['sha'] }}</code>
                        <div class="flex-1">
                            <p class="text-sm text-white">{{ $commit['message'] }}</p>
                            <p class="text-xs text-zinc-400">{{ $commit['author'] }} · {{ $commit['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-4">
                <h2 class="font-semibold text-white mb-4">Open Pull Requests</h2>
                <div class="space-y-3">
                    @foreach([
                        ['title' => 'Add dark mode support', 'author' => 'Alex', 'status' => 'Review', 'color' => 'yellow', 'commits' => 12],
                        ['title' => 'Refactor component system', 'author' => 'Sarah', 'status' => 'Draft', 'color' => 'zinc', 'commits' => 8],
                    ] as $pr)
                    <div class="p-3 bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full {{ $dotColors[$pr['color']] }}"></span>
                            <span class="text-sm font-medium text-white">{{ $pr['title'] }}</span>
                        </div>
                        <p class="text-xs text-zinc-400">{{ $pr['author'] }} · {{ $pr['commits'] }} commits · {{ $pr['status'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
