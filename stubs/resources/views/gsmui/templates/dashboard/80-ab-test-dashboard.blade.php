<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">A/B Test Dashboard</h1>
    </header>
    <main class="p-6">
        @php
        $badgeColors = [
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Active Tests' => '12', 'Completed' => '48', 'Winner Found' => '34', 'Avg Lift' => '+8.3%'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Active Tests</h2>
            <div class="space-y-4">
                @foreach([
                    ['name' => 'Homepage Hero', 'status' => 'Running', 'color' => 'blue', 'lift' => '+12.4%', 'confidence' => '94%'],
                    ['name' => 'CTA Button Color', 'status' => 'Running', 'color' => 'blue', 'lift' => '+5.2%', 'confidence' => '78%'],
                    ['name' => 'Pricing Layout', 'status' => 'Winner', 'color' => 'green', 'lift' => '+18.1%', 'confidence' => '99%'],
                ] as $test)
                <div class="flex items-center gap-4 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $test['name'] }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $badgeColors[$test['color']]['bg'] }} {{ $badgeColors[$test['color']]['text'] }}">{{ $test['status'] }}</span>
                    <span class="text-sm font-medium text-green-600">{{ $test['lift'] }}</span>
                    <span class="text-xs text-zinc-500">{{ $test['confidence'] }} conf.</span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
