<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Employee Directory</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach(['Total Employees' => '234', 'Departments' => '12', 'On Leave' => '8', 'New Hires' => '4'] as $label => $value)
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
            <h2 class="font-semibold text-zinc-900 dark:text-white mb-4">Team Members</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach([
                    ['name' => 'Alex Johnson', 'role' => 'Engineering Lead', 'dept' => 'Engineering', 'avatar' => '👨‍💻'],
                    ['name' => 'Sarah Chen', 'role' => 'Product Manager', 'dept' => 'Product', 'avatar' => '👩‍💼'],
                    ['name' => 'Mike Williams', 'role' => 'Designer', 'dept' => 'Design', 'avatar' => '👨‍🎨'],
                    ['name' => 'Emily Davis', 'role' => 'Data Analyst', 'dept' => 'Analytics', 'avatar' => '👩‍🔬'],
                ] as $employee)
                <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                    <span class="text-2xl">{{ $employee['avatar'] }}</span>
                    <div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $employee['name'] }}</p>
                        <p class="text-xs text-zinc-500">{{ $employee['role'] }} · {{ $employee['dept'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>