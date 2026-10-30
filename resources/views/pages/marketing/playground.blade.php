<x-layouts.marketing>
    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4">
            <h1 class="text-4xl font-bold text-center text-zinc-900 dark:text-white mb-12">Playground</h1>
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                <div class="flex items-center justify-between px-4 py-3 bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Component Playground</span>
                    <div class="flex gap-2">
                        <button class="px-3 py-1 text-xs font-medium text-white bg-purple-600 rounded-md">Run</button>
                        <button class="px-3 py-1 text-xs font-medium text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-800 rounded-md border border-zinc-200 dark:border-zinc-700">Reset</button>
                    </div>
                </div>
                <div class="grid grid-cols-2 divide-x divide-zinc-200 dark:divide-zinc-800">
                    <div class="p-4 bg-zinc-900 text-zinc-100">
                        <pre class="text-sm"><code>&lt;x-gsmui::button variant="primary"&gt;
    Click me
&lt;/x-gsmui::button&gt;</code></pre>
                    </div>
                    <div class="p-8 bg-white dark:bg-zinc-950 flex items-center justify-center min-h-[400px]">
                        <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-500">
                            Click me
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.marketing>
