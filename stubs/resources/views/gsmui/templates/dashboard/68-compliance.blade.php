<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Compliance Dashboard</h1>
    </header>

    <main class="p-6">
        @php
        $statColors = [
            'green' => 'text-green-600',
            'yellow' => 'text-yellow-600',
            'blue' => 'text-blue-600',
            'purple' => 'text-purple-600',
        ];
        $areaScoreColorMap = [
            'green' => 'text-green-600',
            'yellow' => 'text-yellow-600',
        ];
        $areaBarColorMap = [
            'green' => 'bg-green-500',
            'yellow' => 'bg-yellow-500',
        ];
        $issueColorMap = [
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Compliance Score', 'value' => '94%', 'color' => 'green'],
                ['label' => 'Open Issues', 'value' => '7', 'color' => 'yellow'],
                ['label' => 'Audits Completed', 'value' => '12', 'color' => 'blue'],
                ['label' => 'Days to Next Audit', 'value' => '45', 'color' => 'purple'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $statColors[$stat['color']] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Compliance Areas</h2>
                <div class="space-y-3">
                    @foreach([
                        ['area' => 'Data Privacy (GDPR)', 'score' => 98, 'color' => 'green'],
                        ['area' => 'Security (SOC 2)', 'score' => 92, 'color' => 'green'],
                        ['area' => 'Accessibility (WCAG)', 'score' => 85, 'color' => 'yellow'],
                        ['area' => 'Financial (SOX)', 'score' => 96, 'color' => 'green'],
                    ] as $area)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $area['area'] }}</span>
                            <span class="font-medium {{ $areaScoreColorMap[$area['color']] }}">{{ $area['score'] }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full {{ $areaBarColorMap[$area['color']] }} rounded-full" style="width: {{ $area['score'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Open Issues</h2>
                <div class="space-y-3">
                    @foreach([
                        ['issue' => 'Update privacy policy', 'severity' => 'Medium', 'color' => 'yellow', 'due' => 'Jul 15'],
                        ['issue' => 'Complete security training', 'severity' => 'High', 'color' => 'red', 'due' => 'Jun 30'],
                        ['issue' => 'Review access controls', 'severity' => 'Low', 'color' => 'blue', 'due' => 'Aug 1'],
                    ] as $issue)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $issue['issue'] }}</p>
                            <p class="text-xs text-zinc-500">Due: {{ $issue['due'] }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $issueColorMap[$issue['color']]['bg'] }} {{ $issueColorMap[$issue['color']]['text'] }}">{{ $issue['severity'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
