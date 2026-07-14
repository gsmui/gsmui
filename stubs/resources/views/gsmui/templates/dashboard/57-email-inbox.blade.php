<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Inbox</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">Compose</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <nav class="space-y-1">
                    @foreach([
                        ['name' => 'Inbox', 'count' => 23, 'active' => true],
                        ['name' => 'Starred', 'count' => 5, 'active' => false],
                        ['name' => 'Sent', 'count' => null, 'active' => false],
                        ['name' => 'Drafts', 'count' => 3, 'active' => false],
                        ['name' => 'Archive', 'count' => null, 'active' => false],
                    ] as $folder)
                    <a href="#" class="flex items-center justify-between px-3 py-2 rounded-lg {{ $folder['active'] ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                        <span class="text-sm font-medium">{{ $folder['name'] }}</span>
                        @if($folder['count'])
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $folder['active'] ? 'bg-blue-200 text-blue-800 dark:bg-blue-800 dark:text-blue-200' : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400' }}">{{ $folder['count'] }}</span>
                        @endif
                    </a>
                    @endforeach
                </nav>
            </div>

            <div class="lg:col-span-3 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
                <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach([
                        ['from' => 'John Smith', 'subject' => 'Q2 Report Review', 'preview' => 'Hey, can you review the attached report before...', 'time' => '10m ago', 'unread' => true],
                        ['from' => 'Sarah Johnson', 'subject' => 'Meeting Tomorrow', 'preview' => 'Just a reminder about our meeting at 3pm...', 'time' => '1h ago', 'unread' => true],
                        ['from' => 'Mike Davis', 'subject' => 'Project Update', 'preview' => 'Here\'s the latest status on the project...', 'time' => '3h ago', 'unread' => false],
                    ] as $email)
                    <div class="p-4 flex items-start gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50 cursor-pointer {{ $email['unread'] ? 'bg-blue-50/50 dark:bg-blue-900/10' : '' }}">
                        <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400 text-sm font-medium">
                            {{ substr($email['from'], 0, 2) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-medium text-zinc-900 dark:text-white {{ $email['unread'] ? 'font-bold' : '' }}">{{ $email['from'] }}</span>
                                <span class="text-xs text-zinc-500">{{ $email['time'] }}</span>
                            </div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-white {{ $email['unread'] ? '' : 'font-normal' }}">{{ $email['subject'] }}</p>
                            <p class="text-sm text-zinc-500 truncate">{{ $email['preview'] }}</p>
                        </div>
                        @if($email['unread'])
                        <span class="w-2 h-2 bg-blue-500 rounded-full mt-2"></span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
