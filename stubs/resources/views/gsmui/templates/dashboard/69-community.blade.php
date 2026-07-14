<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Community Forum</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ New Post</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Members', 'value' => '12,450'],
                ['label' => 'Posts Today', 'value' => '234'],
                ['label' => 'Active Topics', 'value' => '89'],
                ['label' => 'Online Now', 'value' => '156'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Trending Topics</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['title' => 'Best practices for Livewire components', 'replies' => 47, 'views' => '2.3K', 'author' => 'Alex', 'hot' => true],
                    ['title' => 'Tailwind v4 migration guide', 'replies' => 32, 'views' => '1.8K', 'author' => 'Sarah', 'hot' => true],
                    ['title' => 'Help with authentication setup', 'replies' => 12, 'views' => '890', 'author' => 'Mike', 'hot' => false],
                ] as $topic)
                <div class="p-4 flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $topic['title'] }}</p>
                            @if($topic['hot'])
                            <span class="px-1.5 py-0.5 text-[10px] bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400 rounded">🔥 Hot</span>
                            @endif
                        </div>
                        <p class="text-xs text-zinc-500 mt-1">by {{ $topic['author'] }}</p>
                    </div>
                    <div class="text-right text-sm text-zinc-500">
                        <p>{{ $topic['replies'] }} replies</p>
                        <p>{{ $topic['views'] }} views</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
