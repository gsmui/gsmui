<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Design System</h1>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 text-xs font-medium rounded-full">v2.4.0</span>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Components', 'value' => '48', 'icon' => '🧩'],
                ['label' => 'Tokens', 'value' => '156', 'icon' => '🎨'],
                ['label' => 'Patterns', 'value' => '24', 'icon' => '📐'],
                ['label' => 'Contributors', 'value' => '12', 'icon' => '👥'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $stat['icon'] }}</span>
                    <div>
                        <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Color Palette</h2>
                <div class="grid grid-cols-5 gap-2">
                    @foreach(['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-amber-500', 'bg-red-500', 'bg-blue-400', 'bg-green-400', 'bg-purple-400', 'bg-amber-400', 'bg-red-400'] as $color)
                    <div class="{{ $color }} aspect-square rounded-lg" title="{{ $color }}"></div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Typography</h2>
                <div class="space-y-2">
                    <p class="text-3xl font-bold text-zinc-900 dark:text-white">Heading 1</p>
                    <p class="text-2xl font-semibold text-zinc-900 dark:text-white">Heading 2</p>
                    <p class="text-xl font-medium text-zinc-900 dark:text-white">Heading 3</p>
                    <p class="text-base text-zinc-700 dark:text-zinc-300">Body text</p>
                    <p class="text-sm text-zinc-500">Caption text</p>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Spacing Scale</h2>
                <div class="space-y-2">
                    @foreach([1, 2, 3, 4, 6, 8, 12, 16] as $size)
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-500 rounded" style="width: {{ $size * 4 }}px; height: 16px;"></div>
                        <span class="text-xs text-zinc-500 w-12">{{ $size }} ({{ $size * 4 }}px)</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Component Library</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach(['Button', 'Input', 'Select', 'Modal', 'Table', 'Card', 'Badge', 'Avatar', 'Toast', 'Tooltip', 'Tabs', 'Accordion'] as $component)
                <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg text-center hover:bg-zinc-100 dark:hover:bg-zinc-700 cursor-pointer transition-colors">
                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $component }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
