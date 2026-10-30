<x-layouts.marketing>
    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-zinc-900 dark:text-white">Showcase</h1>
                <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">Projects built with GsmUi by the community</p>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @for($i = 1; $i <= 9; $i++)
                    <div class="group rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden hover:border-purple-500 hover:shadow-lg transition-all">
                        <div class="aspect-video bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 flex items-center justify-center">
                            <span class="text-4xl">🖥️</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-zinc-900 dark:text-white group-hover:text-purple-600 transition-colors">Project {{ $i }}</h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">A beautiful Laravel application built with GsmUi components.</p>
                            <div class="flex items-center gap-2 mt-3">
                                <span class="text-xs bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 px-2 py-1 rounded-full">Laravel</span>
                                <span class="text-xs bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 px-2 py-1 rounded-full">Livewire</span>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-layouts.marketing>
