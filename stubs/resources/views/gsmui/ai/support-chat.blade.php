@props([
    'messages' => [
        ['role' => 'ai', 'text' => 'Hi! I\'m your support assistant. How can I help you today? 😊'],
        ['role' => 'user', 'text' => 'I need help with my account settings'],
        ['role' => 'ai', 'text' => 'I\'d be happy to help! What specific account settings are you looking to update?'],
    ],
    'showTyping' => true,
])

<div {{ $attributes->class('fixed bottom-6 right-6 z-50 w-[22rem] max-w-[calc(100vw-2rem)]') }}>
    <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-2xl overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between bg-gradient-to-r from-blue-600 to-violet-600 px-4 py-3 text-white">
            <div class="flex items-center gap-3">
                <div class="flex size-10 items-center justify-center rounded-full bg-white/20" aria-hidden="true">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                </div>
                <div><p class="font-medium text-sm">Support Assistant</p><p class="text-xs text-blue-200 flex items-center gap-1"><span class="size-1.5 rounded-full bg-emerald-400" aria-hidden="true"></span> Online</p></div>
            </div>
            <button class="rounded-lg p-1.5 hover:bg-white/10 transition-all" aria-label="Minimize"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg></button>
        </div>
        {{-- Messages --}}
        <div class="h-80 overflow-y-auto p-4 space-y-4 bg-zinc-50/50 dark:bg-zinc-900/50">
            @foreach ($messages as $msg)
                <div class="flex items-start gap-3 {{ $msg['role'] === 'user' ? 'justify-end' : '' }}">
                    @if ($msg['role'] !== 'user')
                        <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-violet-500 text-xs font-bold text-white" aria-hidden="true">AI</div>
                    @endif
                    <div class="rounded-2xl {{ $msg['role'] === 'user' ? 'rounded-tr-sm bg-blue-600' : 'rounded-tl-sm bg-white dark:bg-zinc-700' }} px-3.5 py-2.5 {{ $msg['role'] === 'user' ? '' : 'shadow-xs' }}">
                        <p class="text-sm {{ $msg['role'] === 'user' ? 'text-white' : 'text-zinc-700 dark:text-zinc-300' }}">{{ $msg['text'] }}</p>
                    </div>
                    @if ($msg['role'] === 'user')
                        <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-zinc-300 dark:bg-zinc-600 text-xs font-bold text-white" aria-hidden="true">U</div>
                    @endif
                </div>
            @endforeach
            @if ($showTyping)
                <div class="flex items-start gap-3">
                    <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-violet-500 text-xs font-bold text-white" aria-hidden="true">AI</div>
                    <div class="rounded-2xl rounded-tl-sm bg-white dark:bg-zinc-700 px-3.5 py-2.5 shadow-xs">
                        <div class="flex gap-1.5">
                            <span class="size-2 rounded-full bg-zinc-300 dark:bg-zinc-500 animate-bounce" aria-hidden="true"></span>
                            <span class="size-2 rounded-full bg-zinc-300 dark:bg-zinc-500 animate-bounce" style="animation-delay: 0.1s" aria-hidden="true"></span>
                            <span class="size-2 rounded-full bg-zinc-300 dark:bg-zinc-500 animate-bounce" style="animation-delay: 0.2s" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-- Input --}}
        <div class="border-t border-zinc-200 dark:border-white/10 p-3">
            <div class="flex items-center gap-2">
                <button class="rounded-lg p-2 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all" aria-label="Attach file"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/></svg></button>
                <input type="text" placeholder="Type your message..." class="flex-1 border-0 bg-transparent px-2 py-2 text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none focus:ring-0">
                <button class="rounded-lg bg-blue-600 p-2 text-white hover:bg-blue-500 transition-all" aria-label="Send message"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg></button>
            </div>
        </div>
    </div>
</div>
