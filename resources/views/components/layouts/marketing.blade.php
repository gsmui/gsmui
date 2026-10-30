<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }} — {{ config('gsmui.tagline') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100">
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl">
        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-8">
                    <a href="/" class="text-xl font-bold">GsmUi</a>
                    <div class="hidden md:flex items-center gap-6">
                        <a href="/components" class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">Components</a>
                        <a href="/templates" class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">Templates</a>
                        <a href="/docs" class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">Docs</a>
                        <a href="/blog" class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">Blog</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="/dashboard" class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">Sign in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-lg bg-zinc-900 dark:bg-white px-4 py-2 text-sm font-medium text-white dark:text-zinc-900">Get Started</a>
                    @endauth
                    <button id="theme-toggle" class="p-2 text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white">☀️/🌙</button>
                </div>
            </div>
        </nav>
    </header>
    <main>{{ $slot }}</main>
    <footer class="border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 text-center">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">&copy; {{ date('Y') }} {{ config('gsmui.company.name') }}. All rights reserved.</p>
        </div>
    </footer>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>
</html>
