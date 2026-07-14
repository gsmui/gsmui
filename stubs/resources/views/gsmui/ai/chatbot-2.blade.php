@props([
    'messages' => [
        ['role' => 'ai', 'text' => 'Welcome! I\'m here to help you get started. What would you like to know?'],
        ['role' => 'user', 'text' => 'Tell me about pricing'],
        ['role' => 'ai', 'text' => 'Great question! We have three plans: Free ($0), Pro ($29/mo), and Enterprise (custom). Each plan includes different features and support levels.'],
    ],
    'quickReplies' => ['Pricing & Plans', 'Features', 'Documentation'],
])

<div {{ $attributes->class('mx-auto max-w-md rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden') }}>
    <div class="flex items-center justify-between bg-zinc-900 dark:bg-zinc-700 px-4 py-3 text-white">
        <div class="flex items-center gap-3">
            <div class="flex size-9 items-center justify-center rounded-full bg-emerald-500/20" aria-hidden="true"><svg class="size-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg></div>
            <div><p class="font-medium text-sm">SmartBot AI</p><p class="text-xs text-zinc-400">Always online</p></div>
        </div>
        <span class="flex items-center gap-1.5 text-xs text-emerald-400"><span class="size-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span> Online</span>
    </div>
    <div class="h-72 overflow-y-auto p-4 space-y-3 bg-zinc-50/50 dark:bg-zinc-900/50">
        @foreach ($messages as $i => $msg)
            <div class="flex items-start gap-2.5 {{ $msg['role'] === 'user' ? 'justify-end' : '' }}">
                @if ($msg['role'] !== 'user')
                    <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 text-[10px] font-bold text-white" aria-hidden="true">🤖</div>
                @endif
                <div class="rounded-2xl {{ $msg['role'] === 'user' ? 'rounded-tr-sm bg-emerald-600' : 'rounded-tl-sm bg-white dark:bg-zinc-700 shadow-xs' }} px-3.5 py-2.5">
                    <p class="text-sm {{ $msg['role'] === 'user' ? 'text-white' : 'text-zinc-700 dark:text-zinc-300' }}">{{ $msg['text'] }}</p>
                </div>
            </div>
            @if ($i === 0 && count($quickReplies))
                <div class="flex flex-wrap gap-2 ml-9">
                    @foreach ($quickReplies as $reply)
                        <button class="rounded-full border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3.5 py-1.5 text-xs font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-all">{{ $reply }}</button>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
    <div class="border-t border-zinc-200 dark:border-white/10 p-3 bg-white dark:bg-zinc-800"><div class="flex items-center gap-2"><input type="text" placeholder="Ask me anything..." class="flex-1 border-0 bg-zinc-100 dark:bg-zinc-700 rounded-xl px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none focus:ring-0"><button class="rounded-xl bg-emerald-600 px-4 py-2.5 text-white hover:bg-emerald-500 transition-all" aria-label="Send"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg></button></div></div>
</div>
