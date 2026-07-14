<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">AB Testing</h1>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium">+ New Experiment</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Active Tests', 'value' => '8'],
                ['label' => 'Completed', 'value' => '42'],
                ['label' => 'Avg Lift', 'value' => '+12.4%'],
                ['label' => 'Win Rate', 'value' => '68%'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Active Experiments</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['name' => 'Homepage Hero CTA', 'variant' => 'B', 'lift' => '+8.2%', 'status' => 'Running', 'color' => 'green'],
                    ['name' => 'Pricing Page Layout', 'variant' => 'A', 'lift' => '-2.1%', 'status' => 'Running', 'color' => 'yellow'],
                ] as $test)
                <div class="p-4 flex items-center gap-4">
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $test['name'] }}</p>
                        <p class="text-sm text-zinc-500">Variant {{ $test['variant'] }} · {{ $test['status'] }}</p>
                    </div>
                    <span class="text-sm font-medium {{ str_starts_with($test['lift'], '+') ? 'text-green-600' : 'text-red-600' }}">{{ $test['lift'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
