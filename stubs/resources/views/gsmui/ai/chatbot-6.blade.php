@props([
    'conversations' => ['Building a dashboard...', 'React component help', 'API integration guide', 'CSS animation tips'],
    'activeConversation' => 'API integration guide',
    'messages' => [
        ['role' => 'ai', 'text' => 'I\'m looking at your API integration question. Let me help you set up a REST API with proper error handling.'],
        ['role' => 'user', 'text' => 'Can you show me an example with authentication?'],
        ['role' => 'ai', 'text' => 'Sure! Here\'s an example with Bearer token auth:', 'code' => 'const api = axios.create({\n  baseURL: \'https://api.example.com\',\n  headers: { Authorization: `Bearer ${token}` }\n});\n\napi.interceptors.response.use(\n  res => res,\n  err => {\n    if (err.response?.status === 401) refreshToken();\n    return Promise.reject(err);\n  }\n);'],
    ],
])

<div {{ $attributes->class('mx-auto max-w-4xl rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden flex') }}>
    {{-- Sidebar --}}
    <div class="hidden sm:flex w-64 flex-col border-r border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-900/50">
        <div class="p-4 border-b border-zinc-200 dark:border-white/10"><button class="w-full rounded-xl bg-zinc-900 dark:bg-white px-4 py-2.5 text-sm font-semibold text-white dark:text-zinc-900 hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-all">+ New Chat</button></div>
        <div class="flex-1 overflow-y-auto p-3 space-y-1.5">
            @foreach ($conversations as $conv)
                <button class="w-full rounded-lg px-3 py-2.5 text-left text-sm transition-all {{ $conv === $activeConversation ? 'bg-zinc-200 dark:bg-zinc-700 font-medium text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}">{{ $conv }}</button>
            @endforeach
        </div>
        <div class="p-3 border-t border-zinc-200 dark:border-white/10"><div class="flex items-center gap-3"><div class="size-8 rounded-full bg-gradient-to-br from-blue-500 to-violet-500" aria-hidden="true"></div><div><p class="text-sm font-medium text-zinc-900 dark:text-white">User</p><p class="text-xs text-zinc-400">Pro plan</p></div></div></div>
    </div>
    {{-- Chat area --}}
    <div class="flex-1 flex flex-col">
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-zinc-200 dark:border-white/10">
            <div class="flex items-center gap-2.5"><div class="flex size-7 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-violet-500 text-[10px] font-bold text-white" aria-hidden="true">AI</div><span class="text-sm font-medium text-zinc-900 dark:text-white">AI Assistant</span></div>
            <span class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400"><span class="size-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span> Online</span>
        </div>
        <div class="flex-1 overflow-y-auto p-5 space-y-5">
            @foreach ($messages as $msg)
                <div class="flex items-start gap-3 {{ $msg['role'] === 'user' ? 'justify-end' : '' }}">
                    @if ($msg['role'] !== 'user')
                        <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-violet-500 text-[10px] font-bold text-white" aria-hidden="true">AI</div>
                    @endif
                    <div class="{{ $msg['role'] === 'user' ? 'rounded-2xl rounded-tr-sm bg-blue-600 px-4 py-3' : 'rounded-2xl rounded-tl-sm bg-zinc-100 dark:bg-zinc-700 px-4 py-3' }}">
                        <p class="text-sm {{ $msg['role'] === 'user' ? 'text-white' : 'text-zinc-700 dark:text-zinc-300' }}">{{ $msg['text'] }}</p>
                        @if (isset($msg['code']))
                            <div class="mt-3 rounded-xl bg-zinc-900 p-4"><pre class="text-xs text-green-400 font-mono">{{ $msg['code'] }}</pre></div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="border-t border-zinc-200 dark:border-white/10 p-4"><div class="flex items-center gap-2"><input type="text" placeholder="Ask a follow-up..." class="flex-1 rounded-xl border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-3 text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none focus:border-blue-500 transition-all"><button class="rounded-xl bg-blue-600 px-5 py-3 text-white hover:bg-blue-500 transition-all"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg></button></div></div>
    </div>
</div>
