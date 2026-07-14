@props([
    'features' => [
        ['desc' => 'Smart code generation'],
        ['desc' => 'Instant answers'],
        ['desc' => 'Smart suggestions'],
    ],
    'stats' => [
        ['value' => '10x', 'label' => 'Faster coding'],
        ['value' => '95%', 'label' => 'Accuracy rate'],
        ['value' => '50k+', 'label' => 'Users'],
        ['value' => '24/7', 'label' => 'Available'],
    ],
    'buttons' => [
        ['label' => 'Try AI Assistant', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Learn More', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative overflow-hidden rounded-2xl bg-gradient-to-br from-violet-600 to-indigo-700 text-white') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent" aria-hidden="true"></div>
    <div class="relative px-8 py-12 sm:px-12 sm:py-16">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="max-w-xl">
                <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-violet-200">
                    <span class="size-2 rounded-full bg-violet-300 animate-pulse" aria-hidden="true"></span>
                    Powered by Advanced AI
                </div>
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Supercharge Your<br>Workflow with <span class="text-violet-200">AI</span></h2>
                <p class="mt-4 text-lg text-violet-100">Generate components, write code, get instant answers, and boost your productivity with our intelligent AI assistant.</p>
                <div class="mt-6 flex flex-wrap gap-4">
                    @foreach ($features as $feature)
                        <div class="flex items-center gap-2 text-sm text-violet-200">
                            <svg class="size-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                            {{ $feature['desc'] }}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="shrink-0">
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($stats as $stat)
                        <div class="rounded-xl bg-white/10 backdrop-blur-sm p-4 text-center"><p class="text-2xl font-bold">{{ $stat['value'] }}</p><p class="text-xs text-violet-200">{{ $stat['label'] }}</p></div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-8 flex items-center gap-4">
            @foreach ($buttons as $button)
                @if ($button['style'] === 'primary')
                    <a href="{{ $button['href'] }}" class="rounded-xl bg-white px-8 py-3 text-sm font-semibold text-violet-700 hover:bg-violet-50 transition-all">{{ $button['label'] }}</a>
                @else
                    <a href="{{ $button['href'] }}" class="rounded-xl border border-white/20 px-8 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-all">{{ $button['label'] }}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>
