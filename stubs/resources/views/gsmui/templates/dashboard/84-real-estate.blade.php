<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Real Estate Dashboard</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Listings' => '156', 'Sold' => '42', 'Revenue' => '$2.4M', 'Avg Days' => '28'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Featured Properties</h2>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['addr' => '123 Oak Street', 'price' => '$425,000', 'beds' => 3, 'baths' => 2],
                        ['addr' => '456 Maple Ave', 'price' => '$375,000', 'beds' => 2, 'baths' => 2],
                    ] as $prop)
                    <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded-lg overflow-hidden">
                        <div class="h-32 bg-gradient-to-br from-blue-400 to-blue-600"></div>
                        <div class="p-3">
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $prop['addr'] }}</p>
                            <p class="text-lg font-bold text-blue-600">{{ $prop['price'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $prop['beds'] }} bed · {{ $prop['baths'] }} bath</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Inquiries</h2>
                <div class="space-y-3">
                    @foreach(['John D. - Oak Street', 'Sarah M. - Maple Ave'] as $inquiry)
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $inquiry }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>