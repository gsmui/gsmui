@props([
    'ratingButtons' => [
        ['value' => '1', 'hoverColor' => 'red'],
        ['value' => '2', 'hoverColor' => 'orange'],
        ['value' => '3', 'hoverColor' => 'amber'],
        ['value' => '4', 'hoverColor' => 'lime'],
        ['value' => '5', 'hoverColor' => 'emerald', 'active' => true],
    ],
])

<div {{ $attributes->class('rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden') }}>
    <div class="p-5">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2.5">
                <span class="flex size-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-violet-500 text-white text-sm" aria-hidden="true">💡</span>
                <div><p class="font-medium text-sm text-zinc-900 dark:text-white">AI Suggestion</p><p class="text-xs text-zinc-400">Was this helpful?</p></div>
            </div>
            <span class="text-xs text-zinc-400">2 min ago</span>
        </div>
        <div class="rounded-xl bg-zinc-50 dark:bg-zinc-900/50 p-4 mb-4"><p class="text-sm text-zinc-700 dark:text-zinc-300">Based on your code, I recommend using a custom hook for managing form state. This will reduce boilerplate by approximately 40% and improve reusability across your components.</p></div>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <button class="rounded-lg border border-zinc-200 dark:border-white/10 p-2 text-zinc-400 hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400 transition-all" aria-label="Helpful"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z"/></svg></button>
                <button class="rounded-lg border border-zinc-200 dark:border-white/10 p-2 text-zinc-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400 transition-all" aria-label="Not helpful"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 15h2.25m8.024-9.75c.011.05.028.1.052.148.591 1.2.924 2.55.924 3.977a8.96 8.96 0 01-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.339 1.11.521 2.287.521 3.507 0 1.553-.295 3.036-.831 4.398C20.613 14.547 19.833 15 19 15h-1.053c-.472 0-.745-.556-.5-.96a8.95 8.95 0 001.302-4.665c0-1.194-.232-2.333-.654-3.375z"/></svg></button>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-zinc-400"><span>2.4k people found this helpful</span></div>
        </div>
        {{-- Detailed feedback --}}
        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-white/10">
            <p class="text-xs font-medium text-zinc-500 mb-2">Share additional feedback</p>
            <div class="flex gap-2"><input type="text" placeholder="Tell us how to improve..." class="flex-1 rounded-xl bg-zinc-100 dark:bg-zinc-700 border-0 px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none focus:ring-0"><button class="rounded-xl bg-zinc-900 dark:bg-white px-4 py-2 text-sm font-medium text-white dark:text-zinc-900 hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-all">Send</button></div>
        </div>
        {{-- Rating scale --}}
        <div class="mt-4 flex items-center justify-between text-xs text-zinc-400">
            <span>Poor</span>
            <div class="flex gap-1.5">
                @foreach ($ratingButtons as $btn)
                    <button @class([
                        'size-8 rounded-lg text-sm font-medium transition-all',
                        'border border-zinc-200 dark:border-white/10 text-zinc-500 hover:bg-' . $btn['hoverColor'] . '-100 hover:text-' . $btn['hoverColor'] . '-600 dark:hover:bg-' . $btn['hoverColor'] . '-900/20 dark:hover:text-' . $btn['hoverColor'] . '-400' => !isset($btn['active']),
                        'bg-emerald-600 text-white' => isset($btn['active']) && $btn['active'],
                    ])>{{ $btn['value'] }}</button>
                @endforeach
            </div>
            <span>Excellent</span>
        </div>
    </div>
</div>
