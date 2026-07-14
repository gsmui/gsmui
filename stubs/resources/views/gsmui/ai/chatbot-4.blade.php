@props([
    'messages' => [
        ['role' => 'ai', 'text' => 'Hello! I\'m your AI coding assistant. I can help you write, review, and debug code. What are you working on? 🚀'],
        ['role' => 'user', 'text' => 'How do I create a custom hook in React?'],
        ['role' => 'ai', 'text' => 'Here\'s how to create a custom React hook for fetching data:', 'code' => 'function useFetch(url) {\n  const [data, setData] = useState(null);\n  const [loading, setLoading] = useState(true);\n\n  useEffect(() => {\n    fetch(url)\n      .then(res => res.json())\n      .then(data => {\n        setData(data);\n        setLoading(false);\n      });\n  }, [url]);\n\n  return { data, loading };\n}'],
    ],
    'showTyping' => true,
])

<div {{ $attributes->class('mx-auto max-w-lg rounded-3xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-xl overflow-hidden') }}>
    <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-200 dark:border-white/10">
        <div class="flex items-center gap-3">
            <div class="relative"><div class="flex size-10 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 text-white"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/></svg></div><span class="absolute -top-0.5 -right-0.5 size-3 rounded-full border-2 border-white dark:border-zinc-800 bg-emerald-500" aria-hidden="true"></span></div>
            <div><p class="font-medium text-zinc-900 dark:text-white">AI Pro</p><p class="text-xs text-zinc-500">Powered by GPT-4</p></div>
        </div>
        <button class="rounded-lg p-2 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></button>
    </div>
    <div class="h-80 overflow-y-auto p-5 space-y-5 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-900/50 dark:to-zinc-800/50">
        @foreach ($messages as $msg)
            <div class="flex items-start gap-3 {{ $msg['role'] === 'user' ? 'justify-end' : '' }}">
                @if ($msg['role'] !== 'user')
                    <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 text-xs font-bold text-white" aria-hidden="true">AI</div>
                @endif
                <div>
                    <div class="rounded-2xl {{ $msg['role'] === 'user' ? 'rounded-tr-sm bg-gradient-to-r from-cyan-600 to-blue-600' : 'rounded-tl-sm bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-white/10' }} px-4 py-3">
                        <p class="text-sm {{ $msg['role'] === 'user' ? 'text-white' : 'text-zinc-700 dark:text-zinc-300' }}">{{ $msg['text'] }}</p>
                        @if ($msg['role'] === 'ai' && isset($msg['code']))
                            <div class="mt-3 rounded-xl bg-zinc-900 p-4"><pre class="text-xs text-green-400 font-mono leading-relaxed">{{ $msg['code'] }}</pre></div>
                            <div class="mt-2 flex items-center gap-3 text-xs"><button class="flex items-center gap-1 rounded-md bg-zinc-100 dark:bg-zinc-600 px-3 py-1.5 font-medium text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-500 transition-all"><svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75"/></svg> Copy Code</button><button class="flex items-center gap-1 rounded-md bg-zinc-100 dark:bg-zinc-600 px-3 py-1.5 font-medium text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-500 transition-all">👍 Good answer</button></div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        @if ($showTyping)
            <div class="flex items-start gap-3">
                <div class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 text-xs font-bold text-white" aria-hidden="true">AI</div>
                <div class="flex gap-1.5 px-4 py-3"><span class="size-2 rounded-full bg-zinc-300 dark:bg-zinc-500 animate-bounce" aria-hidden="true"></span><span class="size-2 rounded-full bg-zinc-300 dark:bg-zinc-500 animate-bounce" style="animation-delay: 0.15s" aria-hidden="true"></span><span class="size-2 rounded-full bg-zinc-300 dark:bg-zinc-500 animate-bounce" style="animation-delay: 0.3s" aria-hidden="true"></span></div>
            </div>
        @endif
    </div>
    <div class="border-t border-zinc-200 dark:border-white/10 p-4"><div class="flex items-center gap-2"><button class="rounded-xl p-2.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13"/></svg></button><input type="text" placeholder="Ask AI to code something..." class="flex-1 rounded-xl border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none focus:border-cyan-500 transition-all"><button class="rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 px-4 py-2.5 text-white hover:from-cyan-500 hover:to-blue-500 transition-all"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg></button></div><p class="mt-2 text-xs text-zinc-400 text-center">AI responses are for reference only. Verify important information.</p></div>
</div>
