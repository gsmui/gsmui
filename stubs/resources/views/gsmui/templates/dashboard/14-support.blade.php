@extends('gsmui::layouts.demo')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Support Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Open Tickets', 'value' => '23', 'color' => 'red'],
                ['label' => 'In Progress', 'value' => '12', 'color' => 'yellow'],
                ['label' => 'Resolved Today', 'value' => '45', 'color' => 'green'],
                ['label' => 'Avg Response', 'value' => '2.4h', 'color' => 'blue'],
            ] as $stat)
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-5 border border-zinc-200 dark:border-zinc-700">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Recent Tickets</h3>
                <div class="flex gap-2">
                    <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded-lg">All</button>
                    <button class="px-3 py-1 text-sm bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400 rounded-lg">Open</button>
                </div>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach([
                    ['id' => '#TK-1234', 'subject' => 'Login issue', 'customer' => 'John D.', 'priority' => 'High', 'status' => 'Open', 'time' => '5 min ago'],
                    ['id' => '#TK-1233', 'subject' => 'Payment failed', 'customer' => 'Jane S.', 'priority' => 'Critical', 'status' => 'In Progress', 'time' => '15 min ago'],
                    ['id' => '#TK-1232', 'subject' => 'Feature request', 'customer' => 'Bob W.', 'priority' => 'Low', 'status' => 'Resolved', 'time' => '1 hour ago'],
                ] as $ticket)
                    <div class="flex items-center justify-between p-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-mono text-zinc-500 dark:text-zinc-400">{{ $ticket['id'] }}</span>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">{{ $ticket['subject'] }}</p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $ticket['customer'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $ticket['priority'] === 'Critical' ? 'bg-red-100 text-red-700' : ($ticket['priority'] === 'High' ? 'bg-orange-100 text-orange-700' : 'bg-zinc-100 text-zinc-700') }}">{{ $ticket['priority'] }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $ticket['status'] === 'Open' ? 'bg-green-100 text-green-700' : ($ticket['status'] === 'In Progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-zinc-100 text-zinc-700') }}">{{ $ticket['status'] }}</span>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $ticket['time'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
