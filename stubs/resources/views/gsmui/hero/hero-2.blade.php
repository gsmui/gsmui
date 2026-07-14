@props([
    'buttons' => [
        ['label' => 'Start Free Trial', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Talk to Sales', 'href' => '#', 'style' => 'secondary'],
    ],
    'stats' => [
        ['value' => '99.9%', 'label' => 'Uptime'],
        ['value' => '500+', 'label' => 'Enterprises'],
        ['value' => '24/7', 'label' => 'Support'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-6 inline-flex items-center rounded-full border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-white/5 px-4 py-1.5 text-sm text-zinc-600 dark:text-zinc-400">
                    Trusted by 500+ enterprises
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    Transform Your Business
                    <span class="text-zinc-500 dark:text-zinc-400">Operations</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Streamline workflows, boost productivity, and drive growth with our enterprise-grade platform. Join thousands of companies already transforming their operations.
                </p>
                <div class="mt-10 flex items-center gap-4">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}"
                           @class([
                               'rounded-xl px-8 py-3 text-sm font-semibold transition-all duration-200',
                               'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 hover:bg-zinc-700 dark:hover:bg-zinc-100' => $button['style'] === 'primary',
                               'border border-zinc-300 dark:border-white/10 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5' => $button['style'] !== 'primary',
                           ])>{{ $button['label'] }}</a>
                    @endforeach
                </div>
                <div class="mt-12 grid grid-cols-3 gap-8 border-t border-zinc-200 dark:border-white/10 pt-8">
                    @foreach ($stats as $stat)
                        <div>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-800/50 p-6">
                <div class="flex items-center justify-between border-b border-zinc-200 dark:border-white/10 pb-4">
                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Dashboard Overview</span>
                    <span class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400"><span class="size-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span> Live</span>
                </div>
                <div class="mt-6 space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">Active Users</span>
                        <span class="text-lg font-semibold text-zinc-900 dark:text-white">2.4K</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">Projects</span>
                        <span class="text-lg font-semibold text-zinc-900 dark:text-white">156</span>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">System Performance</span>
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">98%</span>
                        </div>
                        <div class="h-2 rounded-full bg-zinc-200 dark:bg-zinc-700">
                            <div class="h-2 w-[98%] rounded-full bg-gradient-to-r from-blue-500 to-violet-500"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
