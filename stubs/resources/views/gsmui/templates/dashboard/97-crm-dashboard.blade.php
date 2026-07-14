<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">CRM Dashboard</h1>
    </header>
    <main class="p-6">
        @php
        $badgeColors = [
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Contacts' => '2,340', 'Deals' => '$124K', 'Pipeline' => '47', 'Won' => '23'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Pipeline</h2>
                <div class="space-y-3">
                    @foreach(['Lead' => 45, 'Qualified' => 23, 'Proposal' => 12, 'Negotiation' => 8] as $stage => $count)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $stage }}</p>
                        </div>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Deals</h2>
                <div class="space-y-3">
                    @foreach([
                        ['company' => 'Acme Corp', 'value' => '$24,000', 'status' => 'Won', 'color' => 'green'],
                        ['company' => 'Global Tech', 'value' => '$12,000', 'status' => 'Pending', 'color' => 'yellow'],
                    ] as $deal)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $deal['company'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $deal['value'] }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$deal['color']]['bg'] }} {{ $badgeColors[$deal['color']]['text'] }}">{{ $deal['status'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
