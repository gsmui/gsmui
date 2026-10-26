<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Components</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_components'] }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Themes</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_themes'] }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Revenue This Month</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">${{ number_format($stats['revenue_this_month'], 2) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h2>
                <div class="space-y-4">
                    <a href="{{ route('admin.users.index') }}" class="block w-full text-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500">
                        Manage Users
                    </a>
                    <a href="{{ route('admin.components.index') }}" class="block w-full text-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500">
                        Manage Components
                    </a>
                    <a href="{{ route('admin.themes.index') }}" class="block w-full text-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500">
                        Manage Themes
                    </a>
                    <a href="{{ route('admin.settings') }}" class="block w-full text-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500">
                        Settings
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Activity</h2>
                <p class="text-gray-500 dark:text-gray-400">Activity log coming soon...</p>
            </div>
        </div>
    </div>
</div>
