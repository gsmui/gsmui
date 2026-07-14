<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">SaaS Metrics</h1>
            <div class="flex items-center gap-2">
                <select class="px-3 py-1.5 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                    <option>Last 30 days</option>
                    <option>Last 90 days</option>
                    <option>This year</option>
                </select>
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'MRR', 'value' => '$124,500', 'change' => '+12.5%', 'up' => true],
                ['label' => 'ARR', 'value' => '$1.49M', 'change' => '+18.2%', 'up' => true],
                ['label' => 'Net Revenue Retention', 'value' => '112%', 'change' => '+2.3%', 'up' => true],
                ['label' => 'CAC Payback', 'value' => '8 mo', 'change' => '-1 mo', 'up' => true],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs {{ $stat['up'] ? 'text-green-600' : 'text-red-600' }}">{{ $stat['change'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Revenue Breakdown</h2>
                <div class="space-y-4">
                    @foreach(['New Business' => '$32,400', 'Expansion' => '$18,200', 'Renewals' => '$74,100', 'Churn' => '-$12,800'] as $source => $amount)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $source }}</span>
                        <span class="text-sm font-medium {{ str_starts_with($amount, '-') ? 'text-red-600' : 'text-green-600' }}">{{ $amount }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Cohort Retention</h2>
                <div class="grid grid-cols-6 gap-1 text-center">
                    @foreach(['Month' => [100, 92, 88, 85, 83, 82], 'Jan' => [100, 89, 84, 80, 78, 0], 'Feb' => [100, 91, 86, 82, 0, 0], 'Mar' => [100, 93, 89, 0, 0, 0]] as $month => $values)
                        @foreach($values as $i => $val)
                            <div @class([
                                'p-2 text-xs rounded',
                                $val === 0 ? 'bg-zinc-100 dark:bg-zinc-700' : '',
                                $val >= 90 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '',
                                $val >= 80 && $val < 90 ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-500' : '',
                                $val < 80 && $val > 0 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '',
                            ])>
                                {{ $val > 0 ? $val . '%' : '' }}
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
