<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Create Chart</h1>

            <form wire:submit="save">
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Chart Name</label>
                            <input type="text" id="name" wire:model="name"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500"
                                   placeholder="My Chart">
                            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Chart Type</label>
                            <select id="type" wire:model="type"
                                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                                <option value="bar">Bar</option>
                                <option value="line">Line</option>
                                <option value="pie">Pie</option>
                                <option value="doughnut">Doughnut</option>
                                <option value="area">Area</option>
                                <option value="radar">Radar</option>
                                <option value="scatter">Scatter</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300">Datasets</label>
                            <button type="button" wire:click="addDataset" class="text-sm text-purple-600 hover:text-purple-700">+ Add Dataset</button>
                        </div>
                        <div class="space-y-4">
                            @foreach($data as $index => $dataset)
                                <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <input type="text" wire:model="data.{{ $index }}.label" placeholder="Dataset label"
                                               class="flex-1 rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 mr-2">
                                        @if(count($data) > 1)
                                            <button type="button" wire:click="removeDataset({{ $index }})" class="text-red-500 hover:text-red-600 text-sm">Remove</button>
                                        @endif
                                    </div>
                                    <input type="text" wire:model="data.{{ $index }}.values" placeholder="Values (comma-separated)"
                                           class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="isPublic" wire:model="isPublic" class="rounded border-zinc-300 text-purple-600 focus:ring-purple-500">
                        <label for="isPublic" class="text-sm text-gray-700 dark:text-zinc-300">Make chart public</label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <a href="{{ route('charts.index') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Create Chart</button>
                </div>
            </form>
        </div>
    </div>
</div>
