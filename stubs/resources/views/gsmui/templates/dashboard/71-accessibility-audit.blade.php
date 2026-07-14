<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Accessibility Audit</h1>
    </header>

    <main class="p-6">
        @php
        $statColors = [
            'green' => 'text-green-600',
            'red' => 'text-red-600',
            'yellow' => 'text-yellow-600',
            'blue' => 'text-blue-600',
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Overall Score', 'value' => '94/100', 'color' => 'green'],
                ['label' => 'Critical Issues', 'value' => '2', 'color' => 'red'],
                ['label' => 'Warnings', 'value' => '12', 'color' => 'yellow'],
                ['label' => 'Passed Rules', 'value' => '156', 'color' => 'blue'],
            ] as $stat)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold {{ $statColors[$stat['color']] }}">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">WCAG Compliance</h2>
                <div class="space-y-3">
                    @foreach([
                        ['level' => 'Level A', 'passed' => 42, 'total' => 45],
                        ['level' => 'Level AA', 'passed' => 38, 'total' => 42],
                        ['level' => 'Level AAA', 'passed' => 12, 'total' => 28],
                    ] as $wcag)
                    <div>
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $wcag['level'] }}</span>
                            <span class="text-zinc-500">{{ $wcag['passed'] }}/{{ $wcag['total'] }}</span>
                        </div>
                        <div class="h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                            <div class="h-full bg-green-500 rounded-full" style="width: {{ ($wcag['passed'] / $wcag['total']) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Critical Issues</h2>
                <div class="space-y-3">
                    @foreach([
                        ['issue' => 'Missing alt text on images', 'element' => '<img>', 'severity' => 'Critical'],
                        ['issue' => 'Insufficient color contrast', 'element' => '.text-muted', 'severity' => 'Critical'],
                    ] as $issue)
                    <div class="p-3 bg-red-50 dark:bg-red-900/10 rounded-lg border border-red-200 dark:border-red-900/30">
                        <p class="text-sm font-medium text-red-800 dark:text-red-400">{{ $issue['issue'] }}</p>
                        <p class="text-xs text-red-600 dark:text-red-500 mt-1 font-mono">{{ $issue['element'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
