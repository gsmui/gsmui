<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Notification Center</h1>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 text-sm text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-700 rounded-lg">Mark all read</button>
                <button class="px-3 py-1.5 text-sm text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-700 rounded-lg">Settings</button>
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Unread', 'value' => '23', 'color' => 'text-red-600'],
                ['label' => 'Today', 'value' => '47', 'color' => 'text-blue-600'],
                ['label' => 'This Week', 'value' => '189', 'color' => 'text-zinc-900 dark:text-white'],
                ['label' => 'Archived', 'value' => '1,234', 'color' => 'text-zinc-600'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['title' => 'New comment on your post', 'desc' => 'John said: "Great article!"', 'time' => '5m ago', 'unread' => true, 'icon' => '💬'],
                    ['title' => 'Payment received', 'desc' => '$49.99 from order #8921', 'time' => '12m ago', 'unread' => true, 'icon' => '💰'],
                    ['title' => 'User signed up', 'desc' => 'sarah@example.com joined', 'time' => '1h ago', 'unread' => true, 'icon' => '👤'],
                    ['title' => 'Deployment completed', 'desc' => 'v2.4.1 deployed successfully', 'time' => '2h ago', 'unread' => false, 'icon' => '🚀'],
                    ['title' => 'Backup completed', 'desc' => 'Daily backup finished', 'time' => '6h ago', 'unread' => false, 'icon' => '📦'],
                ] as $notification)
                <div class="p-4 flex items-start gap-4 {{ $notification['unread'] ? 'bg-blue-50/50 dark:bg-blue-900/10' : '' }} hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                    <span class="text-2xl">{{ $notification['icon'] }}</span>
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $notification['title'] }}</p>
                        <p class="text-sm text-zinc-500">{{ $notification['desc'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-zinc-500">{{ $notification['time'] }}</p>
                        @if($notification['unread'])
                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mt-2"></span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
