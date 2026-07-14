<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Content Management</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ New Post</button>
        </div>
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
            @foreach([
                ['label' => 'Published', 'value' => '156'],
                ['label' => 'Drafts', 'value' => '23'],
                ['label' => 'Scheduled', 'value' => '8'],
                ['label' => 'Total Views', 'value' => '234K'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Recent Posts</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['title' => 'Getting Started with Livewire', 'status' => 'Published', 'color' => 'green', 'views' => '12.4K', 'date' => 'Jun 14'],
                    ['title' => 'Advanced Tailwind Techniques', 'status' => 'Draft', 'color' => 'yellow', 'views' => '—', 'date' => 'Jun 13'],
                    ['title' => 'Laravel Best Practices 2026', 'status' => 'Scheduled', 'color' => 'blue', 'views' => '—', 'date' => 'Jun 20'],
                ] as $post)
                <div class="p-4 flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $post['title'] }}</p>
                        <p class="text-sm text-zinc-500">{{ $post['date'] }} · {{ $post['views'] }} views</p>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $badgeColors[$post['color']]['bg'] }} {{ $badgeColors[$post['color']]['text'] }}">{{ $post['status'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
