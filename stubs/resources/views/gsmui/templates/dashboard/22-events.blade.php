<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Event Management</h1>
            <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium">+ Create Event</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            @foreach([
                ['name' => 'Tech Conference 2026', 'date' => 'Aug 15-17', 'attendees' => '1,234', 'revenue' => '$89,000', 'gradient' => 'from-purple-500 to-pink-500'],
                ['name' => 'Product Launch', 'date' => 'Jul 28', 'attendees' => '456', 'revenue' => '$12,000', 'gradient' => 'from-blue-500 to-cyan-500'],
                ['name' => 'Annual Gala', 'date' => 'Dec 20', 'attendees' => '890', 'revenue' => '$156,000', 'gradient' => 'from-amber-500 to-orange-500'],
            ] as $event)
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div class="h-2 bg-gradient-to-r {{ $event['gradient'] }}"></div>
                <div class="p-4">
                    <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $event['name'] }}</h3>
                    <p class="text-sm text-zinc-500 mt-1">{{ $event['date'] }}</p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $event['attendees'] }} attendees</span>
                        <span class="text-sm font-semibold text-green-600">{{ $event['revenue'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Upcoming Schedule</h2>
            <div class="space-y-3">
                @foreach(['Vendor meeting - 10:00 AM', 'Speaker confirmation call - 2:00 PM', 'Venue walkthrough - 4:00 PM'] as $item)
                <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                    <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
