<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Document Manager</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Documents' => '1,247', 'Shared' => '456', 'Storage' => '12.4 GB', 'Recent' => '23'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Documents</h2>
            <div class="space-y-3">
                @foreach([
                    ['name' => 'Q2 Report.pdf', 'type' => 'PDF', 'size' => '2.4 MB', 'modified' => '2h ago'],
                    ['name' => 'Presentation.pptx', 'type' => 'PPT', 'size' => '8.9 MB', 'modified' => '1d ago'],
                    ['name' => 'Budget.xlsx', 'type' => 'XLS', 'size' => '456 KB', 'modified' => '3d ago'],
                ] as $doc)
                <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <span class="text-2xl">{{ $doc['type'] === 'PDF' ? '📄' : ($doc['type'] === 'PPT' ? '📊' : '📈') }}</span>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $doc['name'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $doc['size'] }} · Modified {{ $doc['modified'] }}</p>
                    </div>
                    <button class="text-zinc-400 hover:text-zinc-600">⋮</button>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>