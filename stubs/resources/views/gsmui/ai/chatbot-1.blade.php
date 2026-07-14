@props([
    'messages' => [
        ['role' => 'ai', 'text' => 'Hello! How can I assist you today?'],
        ['role' => 'user', 'text' => 'What features do you offer?'],
        ['role' => 'ai', 'text' => 'We offer a wide range of UI components including forms, modals, navigation, and more. What would you like to explore?'],
    ],
])

<div {{ $attributes->class('fixed bottom-6 right-6 z-50') }}>
    {{-- Chat bubble button --}}
    <button class="flex size-14 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-violet-600 text-white shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200" aria-label="Open chat">
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
    </button>
    {{-- Chat window --}}
    <div class="absolute bottom-16 right-0 w-80 rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-2xl overflow-hidden hidden group-focus-within:block">
        <div class="bg-gradient-to-r from-blue-600 to-violet-600 px-4 py-3 text-white">
            <p class="font-medium text-sm">AI Assistant</p>
            <p class="text-xs text-blue-200">Ask me anything</p>
        </div>
        <div class="h-64 overflow-y-auto p-4 space-y-3 bg-zinc-50/50 dark:bg-zinc-900/50">
            @foreach ($messages as $msg)
                <div class="flex items-start gap-2 {{ $msg['role'] === 'user' ? 'justify-end' : '' }}">
                    @if ($msg['role'] !== 'user')
                        <div class="flex size-6 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-violet-500 text-[10px] font-bold text-white" aria-hidden="true">AI</div>
                    @endif
                    <p class="rounded-xl {{ $msg['role'] === 'user' ? 'rounded-tr-sm bg-blue-600 text-white' : 'rounded-tl-sm bg-white dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300' }} px-3 py-2 text-xs">{{ $msg['text'] }}</p>
                </div>
            @endforeach
        </div>
        <div class="border-t border-zinc-200 dark:border-white/10 p-3">
            <input type="text" placeholder="Type a message..." class="w-full border-0 bg-transparent text-sm text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 focus:outline-none">
        </div>
    </div>
</div>
