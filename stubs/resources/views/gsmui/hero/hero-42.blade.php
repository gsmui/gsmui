@props([
    'metrics' => [
        ['label' => 'Total Revenue', 'value' => '$128.5K', 'change' => '+12.5%'],
        ['label' => 'Active Users', 'value' => '24,850', 'change' => '+8.2%'],
        ['label' => 'Conversion Rate', 'value' => '4.8%', 'change' => '+2.1%'],
        ['label' => 'Avg. Session', 'value' => '4m 32s', 'change' => '+5.7%'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Your Business<br><span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Metrics at a Glance</span></h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg text-zinc-600 dark:text-zinc-400">Track performance, monitor growth, and make data-driven decisions with our analytics dashboard.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($metrics as $metric)
                <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 p-6">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $metric['label'] }}</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $metric['value'] }}</p>
                    <p class="mt-1 text-sm text-emerald-600 dark:text-emerald-400">{{ $metric['change'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
