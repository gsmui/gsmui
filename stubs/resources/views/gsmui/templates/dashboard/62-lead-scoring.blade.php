<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Lead Scoring</h1>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
            'orange' => ['bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-800 dark:text-orange-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
        ];
        $tierColorMap = [
            'red' => 'bg-red-500',
            'orange' => 'bg-orange-500',
            'yellow' => 'bg-yellow-500',
            'zinc' => 'bg-zinc-400',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Leads', 'value' => '1,247'],
                ['label' => 'Hot Leads', 'value' => '89'],
                ['label' => 'Conversion Rate', 'value' => '12.4%'],
                ['label' => 'Avg Score', 'value' => '67'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Top Leads</h2>
                </div>
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach([
                        ['name' => 'Acme Corp', 'score' => 95, 'status' => 'Hot', 'color' => 'red'],
                        ['name' => 'Global Tech', 'score' => 82, 'status' => 'Warm', 'color' => 'orange'],
                        ['name' => 'StartUp Inc', 'score' => 74, 'status' => 'Warm', 'color' => 'orange'],
                    ] as $lead)
                    <div class="p-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400 text-sm font-medium">
                            {{ substr($lead['name'], 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $lead['name'] }}</p>
                        </div>
                        <span class="text-lg font-bold text-zinc-900 dark:text-white">{{ $lead['score'] }}</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$lead['color']]['bg'] }} {{ $badgeColors[$lead['color']]['text'] }}">{{ $lead['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Score Distribution</h2>
                <div class="space-y-3">
                    @foreach([
                        ['range' => '90-100', 'count' => 23, 'color' => 'red'],
                        ['range' => '70-89', 'count' => 67, 'color' => 'orange'],
                        ['range' => '50-69', 'count' => 134, 'color' => 'yellow'],
                        ['range' => '0-49', 'count' => 1023, 'color' => 'zinc'],
                    ] as $tier)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $tier['range'] }}</span>
                            <span class="text-zinc-500">{{ $tier['count'] }}</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full {{ $tierColorMap[$tier['color']] }} rounded-full" style="width: {{ ($tier['count'] / 1247) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
