@extends('gsmui::layouts.demo')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Analytics Dashboard</h1>
                <p class="text-zinc-500 dark:text-zinc-400">Track your website performance</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="px-4 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    Last 7 days
                </button>
                <button class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg">
                    Export
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Page Views</p>
                    <span class="text-green-500 text-sm font-medium">+12.5%</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">24,521</p>
                <div class="mt-4 h-2 bg-zinc-100 dark:bg-zinc-700 rounded-full">
                    <div class="h-2 bg-blue-500 rounded-full" style="width: 75%"></div>
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Unique Visitors</p>
                    <span class="text-green-500 text-sm font-medium">+8.2%</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">8,432</p>
                <div class="mt-4 h-2 bg-zinc-100 dark:bg-zinc-700 rounded-full">
                    <div class="h-2 bg-green-500 rounded-full" style="width: 60%"></div>
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Bounce Rate</p>
                    <span class="text-red-500 text-sm font-medium">-2.4%</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">32.1%</p>
                <div class="mt-4 h-2 bg-zinc-100 dark:bg-zinc-700 rounded-full">
                    <div class="h-2 bg-amber-500 rounded-full" style="width: 32%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Traffic Overview</h3>
            <div class="h-64 flex items-end gap-2">
                @foreach([65, 45, 75, 55, 80, 60, 70, 85, 50, 90, 75, 85] as $height)
                    <div class="flex-1 bg-blue-500 rounded-t" style="height: {{ $height }}%"></div>
                @endforeach
            </div>
            <div class="flex justify-between mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                    <span>{{ $month }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
