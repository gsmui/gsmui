@blaze(fold: true)

@props([
    'components' => [
        ['id' => 'support-chat', 'name' => 'Support Chat', 'desc' => 'Fixed position chat widget with message history, typing indicator, and input field.'],
        ['id' => 'chatbot-1', 'name' => 'Chatbot Minimal', 'desc' => 'Minimal floating chat bubble with popup window and quick replies.'],
        ['id' => 'chatbot-2', 'name' => 'Chatbot Quick Replies', 'desc' => 'Chat widget with quick reply chips and category buttons.'],
        ['id' => 'chatbot-3', 'name' => 'Chatbot Code Display', 'desc' => 'Chat with code block display and typing indicator animation.'],
        ['id' => 'chatbot-4', 'name' => 'Coding Assistant', 'desc' => 'AI coding assistant with code blocks, suggestions, and feedback buttons.'],
        ['id' => 'chatbot-5', 'name' => 'Chatbot File Upload', 'desc' => 'Chat with file upload support, image previews, and document sharing.'],
        ['id' => 'chatbot-6', 'name' => 'Chatbot Full Page', 'desc' => 'Full-page chat interface with sidebar conversation history.'],
        ['id' => 'ai-assistant', 'name' => 'AI Assistant Panel', 'desc' => 'Context-aware assistant panel with quick action buttons and suggestions.'],
        ['id' => 'ai-banner', 'name' => 'AI Banner', 'desc' => 'Feature callout banner highlighting AI capabilities and stats.'],
        ['id' => 'ai-feedback', 'name' => 'AI Feedback', 'desc' => 'AI suggestion card with rating, feedback buttons, and improvement form.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    {{-- Header --}}
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div>
                <h1 class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro AI Components</h1>
                <p class="text-sm text-zinc-500">{{ count($components) }} AI-powered UI components</p>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="rounded-full bg-cyan-100 dark:bg-cyan-900/30 px-3 py-1 text-xs font-medium text-cyan-700 dark:text-cyan-300">{{ count($components) }} Components</span>
                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">Dark Mode</span>
                <span class="rounded-full bg-violet-100 dark:bg-violet-900/30 px-3 py-1 text-xs font-medium text-violet-700 dark:text-violet-300">Chat & AI</span>
            </div>
        </div>
        {{-- Nav --}}
        <div class="border-t border-zinc-200 dark:border-white/10 overflow-x-auto">
            <div class="mx-auto flex max-w-7xl gap-1 px-6 py-2 text-xs font-medium text-zinc-500">
                @foreach ($components as $comp)
                    <a href="#ai-{{ $comp['id'] }}" class="shrink-0 rounded-md px-2 py-1 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white transition-all whitespace-nowrap">{{ $comp['name'] }}</a>
                @endforeach
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-12 space-y-24">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">AI Components Collection</h2>
            <p class="mt-4 text-zinc-600 dark:text-zinc-400">Chat interfaces, AI assistants, and intelligent UI components for modern applications.</p>
        </div>

        @foreach ($components as $comp)
            <section id="ai-{{ $comp['id'] }}" class="scroll-mt-32">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-cyan-100 dark:bg-cyan-900/30 px-3 py-1 text-xs font-medium text-cyan-700 dark:text-cyan-300">
                            AI Component
                        </span>
                        <h2 class="mt-2 text-xl font-bold text-zinc-900 dark:text-white">{{ $comp['name'] }}</h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $comp['desc'] }}</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-zinc-400">
                        <span class="rounded-md border border-zinc-200 dark:border-white/10 px-2 py-1">gsmui:ai.{{ $comp['id'] }}</span>
                        <button onclick="navigator.clipboard.writeText('&lt;x-gsmui::ai.{{ $comp['id'] }} /&gt;')" class="rounded-md border border-zinc-200 dark:border-white/10 px-2 py-1 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all" title="Copy usage code">Copy</button>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-white/10 shadow-sm">
                    @if(in_array($comp['id'], ['support-chat', 'chatbot-1', 'chatbot-2', 'chatbot-3', 'chatbot-4', 'chatbot-5', 'chatbot-6']))
                        <div class="relative min-h-[28rem] bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-800">
                            <x-dynamic-component :component="'gsmui::ai.' . $comp['id']" />
                        </div>
                    @else
                        <div class="p-8">
                            <x-dynamic-component :component="'gsmui::ai.' . $comp['id']" />
                        </div>
                    @endif
                </div>
            </section>
        @endforeach

        {{-- Footer --}}
        <footer class="border-t border-zinc-200 dark:border-white/10 pt-12 pb-8 text-center">
            <p class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro — {{ count($components) }} AI Components</p>
            <p class="mt-2 text-sm text-zinc-500">Chat interfaces · AI assistants · Smart feedback widgets</p>
            <p class="mt-1 text-xs text-zinc-400">Copy any component with <code class="rounded bg-zinc-200 dark:bg-zinc-700 px-1.5 py-0.5 text-xs font-mono">&lt;x-gsmui::ai.{name} /&gt;</code></p>
        </footer>
    </main>
</div>
