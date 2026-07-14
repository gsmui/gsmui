<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Recruiting ATS</h1>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium">+ New Requisition</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'purple' => ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-800 dark:text-purple-400'],
            'amber' => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-800 dark:text-amber-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Open Positions', 'value' => '18'],
                ['label' => 'Candidates', 'value' => '342'],
                ['label' => 'Interviews', 'value' => '24'],
                ['label' => 'Time to Hire', 'value' => '32 days'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 mb-6">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Hiring Pipeline</h2>
            </div>
            <div class="p-4">
                <div class="flex gap-4">
                    @foreach([
                        ['stage' => 'Applied', 'count' => 156, 'color' => 'bg-zinc-400'],
                        ['stage' => 'Screen', 'count' => 89, 'color' => 'bg-blue-400'],
                        ['stage' => 'Interview', 'count' => 45, 'color' => 'bg-purple-400'],
                        ['stage' => 'Offer', 'count' => 12, 'color' => 'bg-amber-400'],
                        ['stage' => 'Hired', 'count' => 8, 'color' => 'bg-green-500'],
                    ] as $stage)
                    <div class="flex-1 text-center">
                        <div class="h-3 {{ $stage['color'] }} rounded-full mb-2" style="width: {{ ($stage['count'] / 156) * 100 }}%"></div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $stage['count'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $stage['stage'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Top Candidates</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['name' => 'Emily Chen', 'role' => 'Senior Dev', 'stage' => 'Interview', 'color' => 'purple', 'match' => '95%'],
                    ['name' => 'David Park', 'role' => 'Product Lead', 'stage' => 'Offer', 'color' => 'amber', 'match' => '92%'],
                    ['name' => 'Lisa Wang', 'role' => 'Designer', 'stage' => 'Screen', 'color' => 'blue', 'match' => '88%'],
                ] as $candidate)
                <div class="p-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400 font-medium text-sm">
                        {{ substr($candidate['name'], 0, 2) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $candidate['name'] }}</p>
                        <p class="text-sm text-zinc-500">{{ $candidate['role'] }}</p>
                    </div>
                    <span class="text-sm font-medium text-green-600">{{ $candidate['match'] }} match</span>
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $badgeColors[$candidate['color']]['bg'] }} {{ $badgeColors[$candidate['color']]['text'] }}">{{ $candidate['stage'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
