<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Favorites</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $favorites->count() }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Projects</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $projects->count() }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Notifications</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $notifications->count() }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Favorites</h2>
                @if($favorites->count())
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($favorites as $favorite)
                            <li class="py-3">
                                <a href="{{ route('components.show', $favorite->slug) }}" class="text-indigo-600 hover:text-indigo-500">
                                    {{ $favorite->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No favorites yet.</p>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Notifications</h2>
                @if($notifications->count())
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($notifications as $notification)
                            <li class="py-3">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $notification->title }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No notifications.</p>
                @endif
            </div>
        </div>
    </div>
</div>
