@props([
    'messages' => [
        ['role' => 'ai', 'text' => 'Hi there! 👋 I\'m your AI assistant. I can help you with:'],
        ['role' => 'user', 'text' => 'Write a React component for a modal'],
        ['role' => 'ai', 'text' => 'Sure! Here\'s a simple React modal component:', 'code' => 'const Modal = ({ isOpen, onClose, children }) => {\n  if (!isOpen) return null;\n  return (<div className="fixed inset-0 z-50 flex items-center justify-center">...</div>);\n};'],
    ],
    'capabilities' => ['Answering questions', 'Writing code', 'Debugging issues'],
])

<div {{ $attributes->class('mx-auto max-w-md rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden') }}>
    <div class="flex items-center gap-3 border-b border-zinc-200 dark:border-white/10 px-4 py-3">
        <div class="flex size-9 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-purple-600 text-white text-sm font-bold" aria-hidden="true">A</div>
        <div><p class="font-medium text-sm text-zinc-900 dark:text-white">AI Assistant</p><p class="text-xs text-zinc-500">v2.1 · 2.5k conversations</p></div>
        <div class="ml-auto flex gap-1"><button class="rounded-lg p-1.5 text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"/></svg></button></div>
    </div>
    <div class="h-72 overflow-y-auto p-4 space-y-4 bg-gradient-to-b from-zinc-50 to-white dark:from-zinc-900/50 dark:to-zinc-800/50">
        @foreach ($messages as $msg)
            <div class="flex items-start gap-2.5 {{ $msg['role'] === 'user' ? 'justify-end' : '' }}">
                @if ($msg['role'] !== 'user')
                    <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-purple-600 text-[10px] font-bold text-white" aria-hidden="true">A</div>
                @endif
                <div class="rounded-2xl {{ $msg['role'] === 'user' ? 'rounded-tr-sm bg-gradient-to-r from-violet-600 to-purple-600' : 'rounded-tl-sm border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700' }} px-3.5 py-2.5">
                    <p class="text-sm {{ $msg['role'] === 'user' ? 'text-white' : 'text-zinc-700 dark:text-zinc-300' }}">{{ $msg['text'] }}</p>
                    @if ($msg['role'] === 'ai' && isset($msg['code']))
                        <div class="mt-2 rounded-lg bg-zinc-900 p-3"><pre class="text-xs text-green-400 font-mono">{{ $msg['code'] }}</pre></div>
                        <div class="mt-2 flex items-center gap-2 text-xs"><button class="rounded-md bg-zinc-100 dark:bg-zinc-600 px-2.5 py-1.5 font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-500 transition-all">Copy</button><button class="rounded-md bg-zinc-100 dark:bg-zinc-600 px-2.5 py-1.5 font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-500 transition-all">Edit</button></div>
                    @endif
                </div>
            </div>
            @if ($loop->first && count($capabilities))
                <div class="ml-9 mt-2 space-y-1.5">
                    @foreach ($capabilities as $cap)
                        <div class="flex items-center gap-2 text-xs text-zinc-500"><svg class="size-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>{{ $cap }}</div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
    <div class="border-t border-zinc-200 dark:border-white/10 p-3"><div class="flex items-center gap-2"><input type="text" placeholder="Ask AI anything..." class="flex-1 rounded-xl border border-zinc-200 dark:border-white/10 bg-transparent px-4 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none focus:border-violet-500 transition-all"><button class="rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 px-4 py-2.5 text-white hover:from-violet-500 hover:to-purple-500 transition-all"><svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg></button></div></div>
</div>
