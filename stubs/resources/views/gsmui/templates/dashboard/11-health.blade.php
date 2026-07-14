@extends('gsmui::layouts.demo')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Health Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Steps', 'value' => '8,432', 'goal' => '10,000', 'color' => 'blue'],
                ['label' => 'Calories', 'value' => '1,847', 'goal' => '2,200', 'color' => 'orange'],
                ['label' => 'Heart Rate', 'value' => '72 bpm', 'goal' => 'Normal', 'color' => 'red'],
                ['label' => 'Sleep', 'value' => '7.5 hrs', 'goal' => '8 hrs', 'color' => 'purple'],
            ] as $metric)
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-5 border border-zinc-200 dark:border-zinc-700">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $metric['label'] }}</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $metric['value'] }}</p>
                    <p class="text-xs text-zinc-400 mt-1">Goal: {{ $metric['goal'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Weekly Activity</h3>
                <div class="flex items-end justify-between gap-2 h-40">
                    @foreach([65, 80, 45, 90, 70, 85, 60] as $height)
                        <div class="flex-1 bg-blue-500 rounded-t" style="height: {{ $height }}%"></div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-2 text-xs text-zinc-500">
                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                        <span>{{ $day }}</span>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Workouts</h3>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'Morning Run', 'duration' => '32 min', 'calories' => '287', 'date' => 'Today'],
                        ['name' => 'Weight Training', 'duration' => '45 min', 'calories' => '320', 'date' => 'Yesterday'],
                        ['name' => 'Yoga Session', 'duration' => '60 min', 'calories' => '180', 'date' => '2 days ago'],
                    ] as $workout)
                        <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">{{ $workout['name'] }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $workout['date'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $workout['duration'] }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $workout['calories'] }} cal</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
