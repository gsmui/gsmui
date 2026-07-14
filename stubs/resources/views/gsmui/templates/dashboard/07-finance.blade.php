@extends('gsmui::layouts.demo')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Finance Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total Balance</p>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-1">$124,563.00</p>
                <span class="text-sm text-green-500">+$2,345.00 this month</span>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Income</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">$45,231.00</p>
                <span class="text-sm text-green-500">+12.5% from last month</span>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Expenses</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-1">$12,847.00</p>
                <span class="text-sm text-red-500">+5.2% from last month</span>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
            <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Transactions</h3>
            <div class="space-y-4">
                @foreach([
                    ['name' => 'Salary Deposit', 'amount' => '+$5,000.00', 'type' => 'income', 'date' => 'Today'],
                    ['name' => 'Office Rent', 'amount' => '-$2,500.00', 'type' => 'expense', 'date' => 'Yesterday'],
                    ['name' => 'Client Payment', 'amount' => '+$12,000.00', 'type' => 'income', 'date' => '2 days ago'],
                    ['name' => 'Software Subscription', 'amount' => '-$199.00', 'type' => 'expense', 'date' => '3 days ago'],
                ] as $transaction)
                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 {{ $transaction['type'] === 'income' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-full flex items-center justify-center">
                                {{ $transaction['type'] === 'income' ? '↓' : '↑' }}
                            </div>
                            <div>
                                <p class="font-medium text-zinc-900 dark:text-white">{{ $transaction['name'] }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $transaction['date'] }}</p>
                            </div>
                        </div>
                        <span class="font-semibold {{ $transaction['type'] === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">{{ $transaction['amount'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
