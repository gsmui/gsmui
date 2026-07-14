@extends('gsmui::layouts.demo')

@section('content')
<div class="flex h-screen bg-zinc-100 dark:bg-zinc-900">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700 flex flex-col">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Admin Panel</h1>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                <span>📊</span> Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                <span>👥</span> Users
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                <span>📦</span> Products
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700">
                <span>⚙️</span> Settings
            </a>
        </nav>
    </aside>

    {{-- Main content --}}
    <main class="flex-1 overflow-auto">
        <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Dashboard</h2>
        </header>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach(['Revenue' => '$45,231', 'Users' => '2,350', 'Orders' => '1,247', 'Growth' => '+12.5%'] as $label => $value)
                    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $label }}</p>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection
