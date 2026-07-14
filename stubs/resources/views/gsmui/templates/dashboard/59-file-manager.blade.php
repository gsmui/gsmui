<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">File Manager</h1>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700">Upload</button>
                <button class="px-3 py-1.5 text-sm bg-blue-600 text-white rounded-lg">+ New Folder</button>
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center gap-2 text-sm text-zinc-500">
                <span>Home</span>
                <span>/</span>
                <span>Documents</span>
                <span>/</span>
                <span class="text-zinc-900 dark:text-white font-medium">Projects</span>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @foreach([
                        ['name' => 'Design Assets', 'type' => 'folder', 'items' => 24, 'icon' => '📁'],
                        ['name' => 'Documents', 'type' => 'folder', 'items' => 12, 'icon' => '📁'],
                        ['name' => 'Images', 'type' => 'folder', 'items' => 156, 'icon' => '📁'],
                        ['name' => 'report.pdf', 'type' => 'file', 'size' => '2.4 MB', 'icon' => '📄'],
                        ['name' => 'presentation.pptx', 'type' => 'file', 'size' => '8.9 MB', 'icon' => '📊'],
                        ['name' => 'budget.xlsx', 'type' => 'file', 'size' => '456 KB', 'icon' => '📊'],
                    ] as $item)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer text-center">
                        <span class="text-3xl">{{ $item['icon'] }}</span>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white mt-2 truncate">{{ $item['name'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $item['type'] === 'folder' ? $item['items'] . ' items' : $item['size'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
