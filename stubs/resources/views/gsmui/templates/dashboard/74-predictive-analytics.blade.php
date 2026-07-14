<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Predictive Analytics</h1>
    </header>

    <main class="p-6">
        @php
        $statColors = [
            'green' => 'text-green-600',
            'blue' => 'text-blue-600',
            'purple' => 'text-purple-600',
            'amber' => 'text-amber-600',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Model Accuracy', 'value' => '94.2%', 'color' => 'green'],
                ['label' => 'Predictions Made', 'value' => '12,450', 'color' => 'blue'],
                ['label' => 'Revenue Forecast', 'value' => '$245K', 'color' => 'purple'],
                ['label' => 'Confidence', 'value' => '87%', 'color' => 'amber'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $statColors[$stat['color']] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Forecast vs Actual</h2>
                <div class="h-48 flex items-end gap-1">
                    @foreach([65, 72, 68, 85, 78, 92] as $i => $val)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <div class="w-full flex gap-0.5">
                            <div class="flex-1 bg-blue-500 rounded-t" style="height: {{ $val }}%"></div>
                            <div class="flex-1 bg-green-500/50 rounded-t" style="height: {{ $val + rand(-5, 5) }}%"></div>
                        </div>
                        <span class="text-[10px] text-zinc-500">M{{ $i + 1 }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-center gap-4 mt-2 text-xs text-zinc-500">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-500 rounded"></span> Predicted</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 bg-green-500/50 rounded"></span> Actual</span>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Key Insights</h2>
                <div class="space-y-3">
                    @foreach([
                        ['insight' => 'Revenue expected to grow 15% next quarter', 'confidence' => '89%', 'type' => 'positive'],
                        ['insight' => 'Churn risk increases after month 6', 'confidence' => '82%', 'type' => 'warning'],
                        ['insight' => 'Feature X adoption predicted to peak in August', 'confidence' => '76%', 'type' => 'info'],
                    ] as $insight)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg border-l-4 {{ $insight['type'] === 'positive' ? 'border-green-500' : ($insight['type'] === 'warning' ? 'border-yellow-500' : 'border-blue-500') }}">
                        <p class="text-sm text-zinc-900 dark:text-white">{{ $insight['insight'] }}</p>
                        <p class="text-xs text-zinc-500 mt-1">Confidence: {{ $insight['confidence'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
