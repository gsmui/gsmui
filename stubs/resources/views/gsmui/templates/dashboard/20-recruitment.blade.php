<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Recruitment Dashboard</h1>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">+ Post Job</button>
        </div>
    </header>

    <main class="p-6">
        @php
        $badgeColors = [
            'blue' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-800 dark:text-blue-400'],
            'green' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-400'],
            'purple' => ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-800 dark:text-purple-400'],
            'red' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-400'],
            'yellow' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-400'],
            'zinc' => ['bg' => 'bg-zinc-100 dark:bg-zinc-900/30', 'text' => 'text-zinc-800 dark:text-zinc-400'],
        ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">Open Positions</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">12</p>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">Total Applicants</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">247</p>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">Interviews Scheduled</p>
                <p class="text-2xl font-bold text-blue-600">18</p>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">Offers Extended</p>
                <p class="text-2xl font-bold text-green-600">5</p>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 mb-6">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Pipeline Overview</h2>
            </div>
            <div class="p-4">
                <div class="flex items-center gap-4">
                    @foreach([
                        ['stage' => 'Applied', 'count' => 247, 'color' => 'bg-zinc-400'],
                        ['stage' => 'Screening', 'count' => 89, 'color' => 'bg-blue-400'],
                        ['stage' => 'Interview', 'count' => 45, 'color' => 'bg-purple-400'],
                        ['stage' => 'Offer', 'count' => 12, 'color' => 'bg-green-400'],
                        ['stage' => 'Hired', 'count' => 5, 'color' => 'bg-emerald-500'],
                    ] as $item)
                    <div class="flex-1 text-center">
                        <div class="h-2 {{ $item['color'] }} rounded-full mb-2" style="width: {{ ($item['count'] / 247) * 100 }}%"></div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $item['count'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $item['stage'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="font-semibold text-zinc-900 dark:text-white">Recent Applications</h2>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['name' => 'Alex Chen', 'role' => 'Senior Developer', 'stage' => 'Interview', 'color' => 'purple'],
                    ['name' => 'Maria Garcia', 'role' => 'Product Designer', 'stage' => 'Screening', 'color' => 'blue'],
                    ['name' => 'James Wilson', 'role' => 'DevOps Engineer', 'stage' => 'Offer', 'color' => 'green'],
                ] as $applicant)
                <div class="p-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400 font-medium">
                        {{ substr($applicant['name'], 0, 2) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-zinc-900 dark:text-white">{{ $applicant['name'] }}</p>
                        <p class="text-sm text-zinc-500">{{ $applicant['role'] }}</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeColors[$applicant['color']]['bg'] }} {{ $badgeColors[$applicant['color']]['text'] }}">
                        {{ $applicant['stage'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
