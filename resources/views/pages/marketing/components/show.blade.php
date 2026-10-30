<x-layouts.marketing>
    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4">
            <a href="{{ route('components.index') }}" class="text-sm text-purple-600 hover:text-purple-700">← Back to Components</a>
            <div class="mt-8">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $component->name }}</h1>
                <p class="mt-4 text-lg text-zinc-600 dark:text-zinc-400">{{ $component->description }}</p>
            </div>
            @if($component->code_example)
                <div class="mt-8 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                    <div class="px-4 py-3 bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
                        <span class="text-sm font-medium">Code Example</span>
                    </div>
                    <pre class="p-4 bg-zinc-900 text-zinc-100 overflow-x-auto text-sm"><code>{{ $component->code_example }}</code></pre>
                </div>
            @endif
        </div>
    </div>
</x-layouts.marketing>
