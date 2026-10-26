<x-layouts.marketing>
    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4">
            <h1 class="text-4xl font-bold text-center text-zinc-900 dark:text-white mb-12">Blog</h1>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @for($i = 1; $i <= 6; $i++)
                    <article class="rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-48 bg-gradient-to-br from-purple-500 to-blue-500"></div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/50 px-2 py-1 rounded-full">Tutorial</span>
                                <span class="text-xs text-zinc-500">Jan {{ $i }}, 2026</span>
                            </div>
                            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white mb-2">Getting Started with GsmUi Components</h2>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">Learn how to install and use GsmUi components in your Laravel project.</p>
                            <a href="#" class="text-sm font-medium text-purple-600 hover:text-purple-700">Read more →</a>
                        </div>
                    </article>
                @endfor
            </div>
        </div>
    </div>
</x-layouts.marketing>
