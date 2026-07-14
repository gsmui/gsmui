@props([
    'messages' => [
        ['role' => 'ai', 'text' => 'Send me an image and I\'ll analyze it for you! 📸'],
        ['role' => 'user', 'text' => '', 'image' => true, 'imageName' => 'screenshot.png', 'imageSize' => '2.4 MB'],
        ['role' => 'ai', 'text' => 'I can see your screenshot! The UI design looks clean. I notice a few things I can help with:', 'bullets' => ['Consider adding more whitespace', 'The color contrast looks good ✅', 'Button alignment could be improved']],
    ],
])

<div {{ $attributes->class('mx-auto max-w-md rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden') }}>
    <div class="flex items-center justify-between bg-gradient-to-r from-orange-500 to-rose-600 px-4 py-3 text-white">
        <div class="flex items-center gap-2.5"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg><span class="font-medium text-sm">Media Chat</span></div>
        <button class="rounded-lg p-1.5 hover:bg-white/10 transition-all"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <div class="h-72 overflow-y-auto p-4 space-y-4 bg-zinc-50/50 dark:bg-zinc-900/50">
        @foreach ($messages as $msg)
            <div class="flex items-start gap-2.5 {{ $msg['role'] === 'user' ? 'justify-end' : '' }}">
                @if ($msg['role'] !== 'user')
                    <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-orange-500 to-rose-500 text-[10px] font-bold text-white" aria-hidden="true">🤖</div>
                @endif
                <div class="{{ $msg['role'] === 'user' ? '' : 'rounded-2xl rounded-tl-sm bg-white dark:bg-zinc-700 px-3.5 py-2.5 shadow-xs' }}">
                    @if (isset($msg['image']) && $msg['image'])
                        <div class="rounded-2xl rounded-tr-sm bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-white/10 px-3.5 py-2.5">
                            <div class="flex items-center gap-2">
                                <div class="size-12 rounded-lg bg-gradient-to-br from-blue-200 to-blue-400 dark:from-blue-800/30 dark:to-blue-600/20 flex items-center justify-center"><svg class="size-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg></div>
                                <div><p class="text-xs font-medium text-zinc-900 dark:text-white">{{ $msg['imageName'] }}</p><p class="text-xs text-zinc-400">{{ $msg['imageSize'] }}</p></div>
                            </div>
                        </div>
                    @else
                        <p class="text-sm {{ $msg['role'] === 'user' ? 'bg-white dark:bg-zinc-700 rounded-2xl rounded-tr-sm px-3.5 py-2.5' : 'text-zinc-700 dark:text-zinc-300' }}">{{ $msg['text'] }}</p>
                        @if (isset($msg['bullets']))
                            <div class="mt-2 space-y-1.5 text-xs text-zinc-500">
                                @foreach ($msg['bullets'] as $bullet)
                                    <div>• {{ $bullet }}</div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="border-t border-zinc-200 dark:border-white/10 p-3"><div class="flex items-center gap-2"><button class="rounded-xl border border-zinc-300 dark:border-white/10 p-2.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg></button><input type="text" placeholder="Ask about an image..." class="flex-1 border-0 bg-transparent px-2 py-2 text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none"><button class="rounded-xl bg-gradient-to-r from-orange-600 to-rose-600 px-4 py-2.5 text-white hover:from-orange-500 hover:to-rose-500 transition-all"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg></button></div></div>
</div>
