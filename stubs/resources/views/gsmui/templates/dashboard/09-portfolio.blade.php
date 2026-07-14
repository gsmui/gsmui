<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Portfolio</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Add Project</button>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Projects', 'value' => '24'],
                ['label' => 'Clients', 'value' => '18'],
                ['label' => 'Revenue', 'value' => '$89K'],
                ['label' => 'Rating', 'value' => '4.9/5'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Featured Projects</h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'E-commerce Platform', 'category' => 'Web Development', 'revenue' => '$12,400'],
                        ['name' => 'Mobile Banking App', 'category' => 'Mobile Development', 'revenue' => '$24,800'],
                        ['name' => 'Analytics Dashboard', 'category' => 'UI/UX Design', 'revenue' => '$8,600'],
                    ] as $project)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-pink-500 dark:from-violet-600 dark:to-pink-600 rounded-lg flex items-center justify-center text-white text-xl">
                                💼
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-zinc-900 dark:text-white">{{ $project['name'] }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $project['category'] }}</p>
                            </div>
                            <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $project['revenue'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Skills Overview</h2>
                <div class="space-y-3">
                    @foreach([
                        ['skill' => 'React', 'level' => 95],
                        ['skill' => 'Node.js', 'level' => 88],
                        ['skill' => 'TypeScript', 'level' => 92],
                        ['skill' => 'Tailwind CSS', 'level' => 90],
                    ] as $skill)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $skill['skill'] }}</span>
                            <span class="text-zinc-500 dark:text-zinc-400">{{ $skill['level'] }}%</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-2 bg-gradient-to-r from-violet-500 to-pink-500 dark:from-violet-400 dark:to-pink-400 rounded-full" style="width: {{ $skill['level'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
