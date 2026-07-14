<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Content Calendar</h1>
    </header>
    <main class="p-6">
        <div class="grid grid-cols-7 gap-2 mb-6">
            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
            <div class="text-center text-xs font-medium text-zinc-500 py-2">{{ $day }}</div>
            @endforeach
            @foreach(range(1, 35) as $date)
            <div class="aspect-square p-2 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 {{ $date === 15 ? 'ring-2 ring-blue-500' : '' }}">
                <span class="text-sm {{ $date === 15 ? 'font-bold text-blue-600' : 'text-zinc-700 dark:text-zinc-300' }}">{{ $date <= 30 ? $date : '' }}</span>
                @if(in_array($date, [5, 12, 18, 25]))
                <div class="mt-1 w-full h-1 rounded bg-blue-500"></div>
                @endif
                @if(in_array($date, [8, 20]))
                <div class="mt-1 w-full h-1 rounded bg-green-500"></div>
                @endif
            </div>
            @endforeach
        </div>
        <div class="flex items-center gap-4 text-xs text-zinc-500">
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-500 rounded"></span> Blog Posts</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-green-500 rounded"></span> Social Media</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-purple-500 rounded"></span> Newsletter</span>
        </div>
    </main>
</div>