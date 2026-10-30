<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Chart</h1>
                <a href="{{ route('charts.show', $chart->slug) }}" class="text-sm text-purple-600 hover:text-purple-700">View Chart</a>
            </div>

            <form wire:submit="updateChart">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Chart Title</label>
                            <input type="text" id="title" wire:model="title"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                            @error('title') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Description</label>
                            <textarea id="description" wire:model="description" rows="3"
                                      class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 resize-y"></textarea>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Chart Type</label>
                            <select id="type" wire:model="type"
                                    class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500">
                                <option value="bar">Bar Chart</option>
                                <option value="line">Line Chart</option>
                                <option value="pie">Pie Chart</option>
                                <option value="doughnut">Doughnut Chart</option>
                                <option value="radar">Radar Chart</option>
                                <option value="polarArea">Polar Area Chart</option>
                                <option value="scatter">Scatter Chart</option>
                            </select>
                        </div>

                        <div>
                            <label for="labels" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Labels (one per line)</label>
                            <textarea id="labels" wire:model="labels" rows="4"
                                      class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 font-mono resize-y"></textarea>
                            @error('labels') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="data_values" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Data Values (comma-separated)</label>
                            <input type="text" id="data_values" wire:model="data_values"
                                   class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-sm dark:text-white focus:ring-purple-500 focus:border-purple-500 font-mono">
                            @error('data_values') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="bg_color" class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Background Color</label>
                            <input type="color" id="bg_color" wire:model="bg_color" class="w-12 h-10 rounded-lg border border-zinc-300 dark:border-zinc-700 cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Preview</label>
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-6 min-h-[350px] flex items-center justify-center border border-zinc-200 dark:border-zinc-800">
                            <div id="chart-preview">
                                @if($previewData)
                                    <canvas id="preview-canvas" width="400" height="300"></canvas>
                                @else
                                    <p class="text-sm text-zinc-400">Add labels and data to see a preview</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                    <button type="button" wire:click="deleteChart" wire:confirm="Are you sure you want to delete this chart?"
                            class="px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">Delete Chart</button>
                    <div class="flex gap-3">
                        <a href="{{ route('charts.show', $chart->slug) }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 rounded-lg transition-colors">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
