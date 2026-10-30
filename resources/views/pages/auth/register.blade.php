<x-layouts.marketing>
    <div class="flex min-h-screen items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">Create your account</h2>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    Already have an account? <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500">Sign in</a>
                </p>
            </div>
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Full name</label>
                    <input id="name" name="name" type="text" required class="mt-1 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
                </div>
                <div>
                    <label for="username" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Username</label>
                    <input id="username" name="username" type="text" required class="mt-1 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email address</label>
                    <input id="email" name="email" type="email" required class="mt-1 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Password</label>
                    <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 block w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm">
                </div>
                <button type="submit" class="w-full justify-center rounded-lg bg-purple-600 px-4 py-3 text-sm font-semibold text-white hover:bg-purple-500">Create account</button>
            </form>
        </div>
    </div>
</x-layouts.marketing>
