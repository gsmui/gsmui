# Layout System

> Main layout, auth layout, admin layout, docs layout, responsive breakpoints.

## Main Layout

```blade
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-zinc-50 font-sans antialiased dark:bg-zinc-900">
    <div class="flex min-h-full" x-data="{ sidebarOpen: false }">
        {{-- Sidebar --}}
        <aside @class([
            'fixed inset-y-0 left-0 z-50 w-64 transform bg-white transition-transform duration-200 ease-in-out dark:bg-zinc-800',
            'lg:static lg:translate-x-0' => true,
            '-translate-x-full' => !$sidebarOpen,
            'translate-x-0' => $sidebarOpen,
        ])>
            <div class="flex h-16 items-center border-b border-zinc-200 px-6 dark:border-zinc-700">
                <a href="/" class="text-xl font-bold text-zinc-900 dark:text-white">
                    {{ config('app.name') }}
                </a>
            </div>

            <nav class="flex-1 space-y-1 px-3 py-4">
                <x-layouts.sidebar-item
                    icon="home"
                    label="Dashboard"
                    :href="route('dashboard')"
                    :active="request()->routeIs('dashboard')"
                />
                <x-layouts.sidebar-item
                    icon="cube"
                    label="Products"
                    :href="route('products.index')"
                    :active="request()->routeIs('products.*')"
                />
            </nav>
        </aside>

        {{-- Main content --}}
        <main class="flex-1">
            {{-- Top bar --}}
            <header class="sticky top-0 z-40 flex h-16 items-center border-b border-zinc-200 bg-white px-4 dark:border-zinc-700 dark:bg-zinc-800">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden">
                    <x-gsmui::icon name="menu" />
                </button>

                <div class="flex flex-1 items-center justify-between px-4">
                    <div>{{ $pageTitle ?? '' }}</div>
                    <div class="flex items-center gap-4">
                        <x-layouts.user-menu />
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- Mobile sidebar overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-transition.opacity>
    </div>
</body>
</html>
```

## Auth Layout

```blade
{{-- resources/views/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Authentication</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full bg-zinc-50 dark:bg-zinc-900">
    <div class="flex min-h-full flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            {{-- Logo --}}
            <div class="mb-8 text-center">
                <a href="/" class="text-3xl font-bold text-zinc-900 dark:text-white">
                    {{ config('app.name') }}
                </a>
            </div>

            {{-- Card --}}
            <div class="rounded-xl border border-zinc-200 bg-white p-8 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <div class="mt-6 text-center text-sm text-zinc-500">
                {{ $footer ?? '' }}
            </div>
        </div>
    </div>
</body>
</html>

{{-- Usage --}}
<x-layouts.auth>
    <h2 class="mb-6 text-center text-2xl font-bold">Sign in to your account</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <x-gsmui::input label="Email" name="email" type="email" required />
        <x-gsmui::input label="Password" name="password" type="password" required />

        <div class="mt-6">
            <x-gsmui::button type="submit" class="w-full">Sign in</x-gsmui::button>
        </div>
    </form>

    <x-slot name="footer">
        <p>Don't have an account? <a href="{{ route('register') }}" class="text-blue-600">Register</a></p>
    </x-slot>
</x-layouts.auth>
```

## Admin Layout

```blade
{{-- resources/views/layouts/admin.blade.php --}}
<x-layouts.app>
    {{-- Admin navigation --}}
    <x-slot name="sidebar">
        <nav class="space-y-1">
            <x-layouts.sidebar-item icon="cog" label="Settings" :href="route('admin.settings')" />
            <x-layouts.sidebar-item icon="users" label="Users" :href="route('admin.users.index')" />
            <x-layouts.sidebar-item icon="shield" label="Roles" :href="route('admin.roles.index')" />
            <x-layouts.sidebar-item icon="database" label="Cache" :href="route('admin.cache')" />
        </nav>
    </x-slot>

    {{-- Admin content --}}
    <div class="space-y-6">
        {{-- Admin header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                {{ $pageTitle ?? 'Admin' }}
            </h1>
        </div>

        {{ $slot }}
    </div>
</x-layouts.app>
```

## Docs Layout

```blade
{{-- resources/views/layouts/docs.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Documentation' }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/docs.js'])
</head>
<body class="h-full bg-white dark:bg-zinc-900">
    <div class="flex min-h-full">
        {{-- Docs sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 w-72 overflow-y-auto border-r border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-800">
            <nav class="p-4">
                @foreach($navigation as $section => $items)
                    <div class="mb-6">
                        <h3 class="mb-2 text-xs font-semibold uppercase tracking-wider text-zinc-500">
                            {{ $section }}
                        </h3>
                        <ul class="space-y-1">
                            @foreach($items as $item)
                                <li>
                                    <a href="{{ $item['href'] }}"
                                       @class([
                                           'block rounded-md px-3 py-1.5 text-sm',
                                           'bg-blue-50 text-blue-700 font-medium' => $item['active'],
                                           'text-zinc-600 hover:bg-zinc-100' => !$item['active'],
                                       ])>
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        </aside>

        {{-- Docs content --}}
        <main class="ml-72 flex-1">
            <article class="prose prose-zinc dark:prose-invert mx-auto max-w-3xl px-8 py-12">
                {{ $slot }}
            </article>
        </main>
    </div>
</body>
</html>
```

## Responsive Breakpoints

| Breakpoint | Width | Usage |
|---|---|---|
| `sm` | 640px | Mobile landscape |
| `md` | 768px | Tablet portrait |
| `lg` | 1024px | Tablet landscape / Small desktop |
| `xl` | 1280px | Desktop |
| `2xl` | 1536px | Large desktop |

## Layout Patterns

```blade
{{-- Grid layout --}}
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    @foreach($items as $item)
        <x-gsmui::card>
            {{ $item->name }}
        </x-gsmui::card>
    @endforeach
</div>

{{-- Sidebar + content --}}
<div class="flex gap-6">
    <aside class="w-64 shrink-0">
        {{-- Sidebar content --}}
    </aside>
    <main class="flex-1">
        {{-- Main content --}}
    </main>
</div>

{{-- Sticky header --}}
<div class="sticky top-0 z-40 border-b border-zinc-200 bg-white">
    {{-- Header content --}}
</div>
```
