<x-layouts.admin title="Settings">
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">General Settings</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Site Name</label>
                        <input type="text" name="site_name" value="{{ config('gsmui.name') }}" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Tagline</label>
                        <input type="text" name="tagline" value="{{ config('gsmui.tagline') }}" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Company Email</label>
                        <input type="email" name="company_email" value="{{ config('gsmui.company.email') }}" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Feature Toggles</h2>
                <div class="space-y-3">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="marketplace" value="1" {{ config('gsmui.features.marketplace') ? 'checked' : '' }} class="rounded border-zinc-300 dark:border-zinc-700 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Enable Marketplace</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="blog" value="1" {{ config('gsmui.features.blog') ? 'checked' : '' }} class="rounded border-zinc-300 dark:border-zinc-700 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Enable Blog</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="showcase" value="1" {{ config('gsmui.features.showcase') ? 'checked' : '' }} class="rounded border-zinc-300 dark:border-zinc-700 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Enable Showcase</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="playground" value="1" {{ config('gsmui.features.playground') ? 'checked' : '' }} class="rounded border-zinc-300 dark:border-zinc-700 text-purple-600 focus:ring-purple-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Enable Playground</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                Save Settings
            </button>
        </form>
    </div>
</x-layouts.admin>
