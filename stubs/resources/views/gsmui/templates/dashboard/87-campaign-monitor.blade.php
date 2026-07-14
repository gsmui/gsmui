<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Campaign Monitor</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Active Campaigns' => '8', 'Total Reach' => '245K', 'Conversions' => '3,420', 'ROI' => '340%'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Campaign Performance</h2>
            <div class="space-y-4">
                @foreach([
                    ['name' => 'Summer Sale', 'reach' => '124K', 'conv' => '2.8%', 'revenue' => '$45,200', 'status' => 'Active'],
                    ['name' => 'New Product Launch', 'reach' => '89K', 'conv' => '4.2%', 'revenue' => '$67,800', 'status' => 'Active'],
                    ['name' => 'Brand Awareness', 'reach' => '234K', 'conv' => '1.2%', 'revenue' => '$12,400', 'status' => 'Completed'],
                ] as $campaign)
                <div class="flex items-center gap-4 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $campaign['name'] }}</p>
                        <p class="text-xs text-zinc-500">Reach: {{ $campaign['reach'] }} · Conv: {{ $campaign['conv'] }}</p>
                    </div>
                    <span class="text-sm font-bold text-green-600">{{ $campaign['revenue'] }}</span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $campaign['status'] === 'Active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400' }}">{{ $campaign['status'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>