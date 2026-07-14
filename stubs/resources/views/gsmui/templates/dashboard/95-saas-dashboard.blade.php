<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">SaaS Dashboard</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['MRR' => '$45.2K', 'Customers' => '1,247', 'Churn' => '2.1%', 'NPS' => '+62'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Revenue Trend</h2>
                <div class="h-48 flex items-end gap-2">
                    @foreach([65, 72, 68, 85, 78, 92, 88, 95] as $i => $val)
                    <div class="flex-1 bg-blue-500 rounded-t" style="height: {{ $val }}%"></div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Plan Distribution</h2>
                <div class="space-y-3">
                    @foreach(['Free' => 60, 'Starter' => 25, 'Pro' => 12, 'Enterprise' => 3] as $plan => $pct)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $plan }}</span>
                            <span class="text-zinc-500">{{ $pct }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>