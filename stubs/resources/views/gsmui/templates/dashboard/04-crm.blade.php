<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">CRM Dashboard</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ New Contact</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Total Contacts', 'value' => '2,340'],
                ['label' => 'Deals', 'value' => '124'],
                ['label' => 'Revenue', 'value' => '$45.2K'],
                ['label' => 'Conversion', 'value' => '32%'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Contacts</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'John Smith', 'email' => 'john@example.com', 'avatar' => 'JS'],
                        ['name' => 'Sarah Johnson', 'email' => 'sarah@example.com', 'avatar' => 'SJ'],
                        ['name' => 'Mike Davis', 'email' => 'mike@example.com', 'avatar' => 'MD'],
                    ] as $contact)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 dark:from-blue-500 dark:to-purple-600 rounded-full flex items-center justify-center text-white font-medium text-sm">
                            {{ $contact['avatar'] }}
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $contact['name'] }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $contact['email'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Pipeline</h2>
                <div class="space-y-3">
                    @foreach([
                        ['stage' => 'Leads', 'count' => 45],
                        ['stage' => 'Qualified', 'count' => 32],
                        ['stage' => 'Proposal', 'count' => 18],
                        ['stage' => 'Negotiation', 'count' => 12],
                    ] as $stage)
                    <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $stage['stage'] }}</p>
                        </div>
                        <span class="text-sm font-bold text-zinc-600 dark:text-zinc-300">{{ $stage['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
