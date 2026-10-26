<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100">
    <div class="flex min-h-screen">
        <aside class="fixed inset-y-0 left-0 z-50 w-64 border-r border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
            <div class="flex flex-col h-full">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                    <a href="/" class="text-lg font-bold">GsmUi</a>
                    <span class="ml-2 text-xs bg-red-50 dark:bg-red-900/50 text-red-700 dark:text-red-400 px-2 py-0.5 rounded-full">Admin</span>
                </div>
                <nav class="flex-1 px-4 py-4 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-100 dark:bg-zinc-800' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-zinc-100 dark:bg-zinc-800' : '' }}">Users</a>
                    <a href="{{ route('admin.components.index') }}" class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('admin.components.*') ? 'bg-zinc-100 dark:bg-zinc-800' : '' }}">Components</a>
                </nav>
            </div>
        </aside>
        <div class="flex-1 ml-64">
            <header class="sticky top-0 z-40 border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-6 py-3">
                <h1 class="text-lg font-semibold">{{ $title ?? 'Dashboard' }}</h1>
            </header>
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/50 p-4 text-sm text-green-700 dark:text-green-400">{{ session('success') }}</div>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>
</html>
