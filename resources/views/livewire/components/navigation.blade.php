<nav class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                    GsmUi
                </a>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('components.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600">
                    Components
                </a>
                <a href="{{ route('docs.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600">
                    Docs
                </a>
            </div>
        </div>
    </div>
</nav>
