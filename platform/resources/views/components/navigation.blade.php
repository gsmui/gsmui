<?php
$navigation = [
    ['name' => 'Components', 'route' => 'components.index', 'active' => request()->routeIs('components.*')],
    ['name' => 'Themes', 'route' => 'themes.index', 'active' => request()->routeIs('themes.*')],
    ['name' => 'Templates', 'route' => 'templates.index', 'active' => request()->routeIs('templates.*')],
    ['name' => 'Documentation', 'route' => 'docs.index', 'active' => request()->routeIs('docs.*')],
    ['name' => 'Blog', 'route' => 'blog.index', 'active' => request()->routeIs('blog.*')],
    ['name' => 'Marketplace', 'route' => 'marketplace.index', 'active' => request()->routeIs('marketplace.*')],
];
?>
<header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                        GsmUi
                    </a>
                </div>
                <nav class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    @foreach($navigation as $item)
                        <a href="{{ route($item['route']) }}"
                           class="{{ $item['active'] ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            {{ $item['name'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                        Dashboard
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            Admin
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="ml-4 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
