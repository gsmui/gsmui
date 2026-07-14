@extends('gsmui::layouts.demo')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Social Media Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['platform' => 'Twitter', 'followers' => '12.4K', 'growth' => '+5.2%', 'icon' => '🐦', 'color' => 'blue'],
                ['platform' => 'Instagram', 'followers' => '24.8K', 'growth' => '+8.1%', 'icon' => '📷', 'color' => 'pink'],
                ['platform' => 'LinkedIn', 'followers' => '8.2K', 'growth' => '+3.4%', 'icon' => '💼', 'color' => 'blue'],
                ['platform' => 'YouTube', 'followers' => '45.1K', 'growth' => '+12.3%', 'icon' => '📺', 'color' => 'red'],
            ] as $social)
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-5 border border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-2xl">{{ $social['icon'] }}</span>
                        <span class="font-medium text-zinc-900 dark:text-white">{{ $social['platform'] }}</span>
                    </div>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $social['followers'] }}</p>
                    <p class="text-sm text-green-500">{{ $social['growth'] }} followers</p>
                </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
            <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Posts</h3>
            <div class="space-y-4">
                @foreach([
                    ['content' => 'Just launched our new product! Check it out 🚀', 'platform' => 'Twitter', 'likes' => 234, 'comments' => 45, 'shares' => 12],
                    ['content' => 'Behind the scenes at our office today', 'platform' => 'Instagram', 'likes' => 567, 'comments' => 89, 'shares' => 23],
                ] as $post)
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-sm font-medium text-blue-500">{{ $post['platform'] }}</span>
                            <span class="text-zinc-400">·</span>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">2 hours ago</span>
                        </div>
                        <p class="text-zinc-900 dark:text-white">{{ $post['content'] }}</p>
                        <div class="flex items-center gap-4 mt-3 text-sm text-zinc-500 dark:text-zinc-400">
                            <span>❤️ {{ $post['likes'] }}</span>
                            <span>💬 {{ $post['comments'] }}</span>
                            <span>🔄 {{ $post['shares'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
