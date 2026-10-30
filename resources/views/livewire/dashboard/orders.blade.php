<div>
    <div class="max-w-4xl">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6">Order History</h1>

        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <p class="font-medium text-zinc-900 dark:text-white">Order #{{ $order->order_number }}</p>
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                    {{ $order->status === 'completed' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : '' }}
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' : '' }}
                                    {{ $order->status === 'failed' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-zinc-900 dark:text-white">${{ number_format($order->total, 2) }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $order->items->count() }} item(s)</p>
                        </div>
                    </div>

                    @if($order->items->count())
                        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-800 space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-zinc-600 dark:text-zinc-400">{{ $item->name }}</span>
                                    <span class="text-zinc-900 dark:text-white">${{ number_format($item->price, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="text-xs text-purple-600 hover:text-purple-700 font-medium">View Details</a>
                        @if($order->status === 'completed')
                            <span class="text-zinc-300 dark:text-zinc-700">|</span>
                            <a href="{{ route('orders.invoice', $order->id) }}" class="text-xs text-purple-600 hover:text-purple-700 font-medium">Download Invoice</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800">
                    <svg class="w-12 h-12 mx-auto text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    <p class="text-zinc-500 dark:text-zinc-400">No orders yet.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
