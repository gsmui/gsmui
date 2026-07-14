@props([
    'buttons' => [
        ['label' => 'Start exploring', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Watch video', 'href' => '#', 'style' => 'secondary'],
    ],
    'features' => [
        ['icon' => 'users', 'title' => 'Team Chat', 'desc' => 'Real-time messaging'],
        ['icon' => 'document', 'title' => 'Task Boards', 'desc' => 'Kanban style'],
        ['icon' => 'chat', 'title' => 'Discussions', 'desc' => 'Threaded conversations'],
        ['icon' => 'image', 'title' => 'File Sharing', 'desc' => 'Secure uploads'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-indigo-600 to-purple-700 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Collaborate seamlessly<br>with <span class="text-indigo-200">Gsmui Pro</span></h1>
                <p class="mt-6 text-lg leading-8 text-indigo-100">Empower your team with Gsmui Pro's tools for effortless collaboration and productivity.</p>
                <div class="mt-10 flex items-center gap-4">
                    @foreach ($buttons as $button)
                        @if ($button['style'] === 'primary')
                            <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-indigo-700 hover:bg-indigo-50 transition-all">{{ $button['label'] }}</a>
                        @else
                            <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl border border-white/20 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-all">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z"/></svg>
                                {{ $button['label'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-white/10 bg-white/5 p-4 backdrop-blur-sm">
                        @if ($feature['icon'] === 'users')
                            <svg class="size-8 text-indigo-200 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                        @elseif ($feature['icon'] === 'document')
                            <svg class="size-8 text-indigo-200 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15a2.25 2.25 0 012.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/></svg>
                        @elseif ($feature['icon'] === 'chat')
                            <svg class="size-8 text-indigo-200 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                        @elseif ($feature['icon'] === 'image')
                            <svg class="size-8 text-indigo-200 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                        @endif
                        <p class="font-medium">{{ $feature['title'] }}</p>
                        <p class="text-sm text-indigo-200">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
