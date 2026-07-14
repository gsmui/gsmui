@props([
    'buttons' => [
        ['label' => 'Get Started Free', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Learn More', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative overflow-hidden bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 text-white') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-500/10 via-transparent to-transparent" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-1.5 text-sm text-zinc-300">
                <span class="size-2 rounded-full bg-emerald-400" aria-hidden="true"></span>
                macOS Menubar App
            </div>
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                Refine your writing with a single
                <span class="bg-gradient-to-r from-blue-400 to-violet-400 bg-clip-text text-transparent">shortcut</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-zinc-400">
                Instantly clean up copied text. Press <kbd class="rounded-md border border-white/10 bg-white/5 px-2 py-0.5 font-mono text-sm text-zinc-300">⌘+Shift+E</kbd> anywhere on macOS to replace messy text with a clearer, corrected version.
            </p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}"
                       @class([
                           'rounded-xl px-8 py-3 text-sm font-semibold transition-all duration-200',
                           'bg-blue-600 text-white shadow-sm hover:bg-blue-500' => $button['style'] === 'primary',
                           'border border-white/10 text-zinc-300 hover:bg-white/5' => $button['style'] !== 'primary',
                       ])>{{ $button['label'] }}</a>
                @endforeach
            </div>
            <div class="mt-16 rounded-2xl border border-white/10 bg-white/5 p-2 backdrop-blur-sm">
                <div class="rounded-xl border border-white/5 bg-zinc-900/50 p-6">
                    <div class="flex items-center gap-3 border-b border-white/10 pb-4">
                        <div class="flex gap-1.5">
                            <span class="size-3 rounded-full bg-red-500" aria-hidden="true"></span>
                            <span class="size-3 rounded-full bg-yellow-500" aria-hidden="true"></span>
                            <span class="size-3 rounded-full bg-green-500" aria-hidden="true"></span>
                        </div>
                        <span class="text-sm text-zinc-500">Text Editor</span>
                    </div>
                    <div class="mt-4 space-y-2">
                        <p class="text-sm text-zinc-400">Press <kbd class="rounded border border-white/10 bg-white/5 px-1.5 py-0.5 text-xs">⌘+Shift+E</kbd> to refine</p>
                        <div class="rounded-lg bg-zinc-800/50 p-4">
                            <p class="text-sm text-zinc-300">The quick brown fox jumps over the lazy dog. This text needs refinement and cleaning up for better readability.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
