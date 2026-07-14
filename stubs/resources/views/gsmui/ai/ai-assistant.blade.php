@props([
    'actions' => [
        ['icon' => 'chat', 'label' => 'Summarize', 'color' => 'blue'],
        ['icon' => 'document', 'label' => 'Rewrite', 'color' => 'violet'],
        ['icon' => 'sparkle', 'label' => 'Improve', 'color' => 'emerald'],
        ['icon' => 'chat-bubble', 'label' => 'Reply', 'color' => 'amber'],
    ],
])

<div {{ $attributes->class('rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden') }}>
    {{-- Header --}}
    <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-200 dark:border-white/10">
        <div class="flex items-center gap-2.5">
            <span class="flex size-8 items-center justify-center rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 text-white text-sm" aria-hidden="true">✨</span>
            <div><p class="font-medium text-sm text-zinc-900 dark:text-white">AI Assistant</p><p class="text-xs text-zinc-400">Context-aware · Pro features</p></div>
        </div>
        <div class="flex gap-1">
            <button class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75v-8.25m-10.5 6l6.75-6.75m0 0l-4.5-4.5m4.5 4.5H12m3.75 0h3.75"/></svg></button>
            <button class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/></svg></button>
        </div>
    </div>
    {{-- Suggestions --}}
    <div class="p-4 space-y-3 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-900/50 dark:to-zinc-800/50">
        <p class="text-xs font-medium uppercase tracking-wider text-zinc-400">Quick Actions</p>
        <div class="grid grid-cols-2 gap-2">
            @foreach ($actions as $action)
                <button class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 p-3 text-left hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-all">
                    @if ($action['icon'] === 'chat')
                        <svg class="size-5 text-{{ $action['color'] }}-500 mb-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                    @elseif ($action['icon'] === 'document')
                        <svg class="size-5 text-{{ $action['color'] }}-500 mb-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                    @elseif ($action['icon'] === 'sparkle')
                        <svg class="size-5 text-{{ $action['color'] }}-500 mb-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                    @elseif ($action['icon'] === 'chat-bubble')
                        <svg class="size-5 text-{{ $action['color'] }}-500 mb-1.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z"/></svg>
                    @endif
                    <p class="text-xs font-medium text-zinc-900 dark:text-white">{{ $action['label'] }}</p>
                </button>
            @endforeach
        </div>
        <div class="mt-4 rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 p-3"><p class="text-xs font-medium text-zinc-900 dark:text-white">Generate component code</p><p class="mt-1 text-xs text-zinc-400">Ask AI to create any UI component with code</p><div class="mt-2 flex gap-2"><button class="rounded-lg bg-gradient-to-r from-amber-500 to-orange-600 px-3 py-1.5 text-xs font-medium text-white hover:from-amber-400 hover:to-orange-500 transition-all">Try Now</button></div></div>
    </div>
    {{-- Input --}}
    <div class="border-t border-zinc-200 dark:border-white/10 p-3"><input type="text" placeholder="Ask AI anything..." class="w-full rounded-xl bg-zinc-100 dark:bg-zinc-700 border-0 px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none focus:ring-0"></div>
</div>
