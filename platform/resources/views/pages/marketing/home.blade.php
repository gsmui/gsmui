<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Build with <span class="text-indigo-600">GsmUi</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    A complete UI component library for Livewire. 200+ premium components with dark mode, CSP support, and comprehensive theming.
                </p>
                <div class="mt-8 flex justify-center gap-4">
                    <a href="{{ route('components.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500">
                        Browse Components
                    </a>
                    <a href="{{ route('docs.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Documentation
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-2">200+</div>
                    <div class="text-gray-600 dark:text-gray-400">Components</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-2">50+</div>
                    <div class="text-gray-600 dark:text-gray-400">Themes</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-2">10K+</div>
                    <div class="text-gray-600 dark:text-gray-400">Downloads</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Why GsmUi?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Built for Livewire</h3>
                            <p class="text-gray-600 dark:text-gray-400">Native Livewire components with full PHP support.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Dark Mode</h3>
                            <p class="text-gray-600 dark:text-gray-400">Beautiful dark mode support out of the box.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">CSP Support</h3>
                            <p class="text-gray-600 dark:text-gray-400">Full Content Security Policy support.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Comprehensive Theming</h3>
                            <p class="text-gray-600 dark:text-gray-400">Customize every aspect with CSS variables.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
