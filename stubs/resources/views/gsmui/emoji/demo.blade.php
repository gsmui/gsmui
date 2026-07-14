@extends('gsmui::layouts.demo')

@section('title', 'Emoji Components Demo')

@section('content')
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 py-12">
    <div class="max-w-6xl mx-auto px-6">
        {{-- Header --}}
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold text-zinc-900 dark:text-white mb-4">Emoji Components</h1>
            <p class="text-lg text-zinc-600 dark:text-zinc-400">A comprehensive set of emoji components for your Laravel Livewire projects</p>
        </div>

        {{-- Component Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- 1. Main Emoji Picker --}}
            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <span class="text-xl">🎯</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Emoji Picker</h2>
                        <p class="text-sm text-zinc-500">Full-featured picker with search and categories</p>
                    </div>
                </div>
                
                <div x-data="{ selectedEmoji: '😀' }" @emoji-select.window="selectedEmoji = $event.detail">
                    <div class="mb-4 p-4 bg-zinc-50 dark:bg-zinc-700/50 rounded-xl">
                        <p class="text-sm text-zinc-500 mb-2">Selected:</p>
                        <div class="flex items-center gap-2">
                            <span class="text-3xl" x-text="selectedEmoji">😀</span>
                            <code class="text-sm text-zinc-600 dark:text-zinc-400" x-text="selectedEmoji">😀</code>
                        </div>
                    </div>
                    
                    <x-gsmui::emoji.index label="Choose an emoji" />
                </div>
            </div>

            {{-- 2. Emoji Grid --}}
            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                        <span class="text-xl">📊</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Emoji Grid</h2>
                        <p class="text-sm text-zinc-500">Simple grid display of emojis</p>
                    </div>
                </div>

                <x-gsmui::emoji.grid 
                    label="Smileys" 
                    :emojis="['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩']"
                    :columns="8"
                />

                <x-gsmui::emoji.grid 
                    label="Nature" 
                    class="mt-4"
                    :emojis="['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮']"
                    :columns="6"
                    size="lg"
                />
            </div>

            {{-- 3. Emoji Display --}}
            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <span class="text-xl">🖼️</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Emoji Display</h2>
                        <p class="text-sm text-zinc-500">Individual emoji display with sizes</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-medium text-zinc-500 mb-2 uppercase tracking-wide">Sizes</p>
                        <div class="flex items-end gap-4">
                            <x-gsmui::emoji.display emoji="😀" size="xs" label="xs" />
                            <x-gsmui::emoji.display emoji="😀" size="sm" label="sm" />
                            <x-gsmui::emoji.display emoji="😀" size="md" label="md" />
                            <x-gsmui::emoji.display emoji="😀" size="lg" label="lg" />
                            <x-gsmui::emoji.display emoji="😀" size="xl" label="xl" />
                            <x-gsmui::emoji.display emoji="😀" size="2xl" label="2xl" />
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-zinc-500 mb-2 uppercase tracking-wide">Copyable (Click to copy)</p>
                        <div class="flex items-center gap-4">
                            <x-gsmui::emoji.display emoji="🎉" size="xl" copyable label="Copy me" />
                            <x-gsmui::emoji.display emoji="✨" size="xl" copyable />
                            <x-gsmui::emoji.display emoji="🚀" size="xl" copyable />
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. Emoji Reactions --}}
            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                        <span class="text-xl">💬</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Emoji Reactions</h2>
                        <p class="text-sm text-zinc-500">Interactive reaction buttons with counts</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-medium text-zinc-500 mb-2 uppercase tracking-wide">Default State</p>
                        <div class="flex flex-wrap gap-2">
                            <x-gsmui::emoji.reaction emoji="👍" :count="12" label="Like" />
                            <x-gsmui::emoji.reaction emoji="❤️" :count="8" label="Love" />
                            <x-gsmui::emoji.reaction emoji="😂" :count="5" label="Laugh" />
                            <x-gsmui::emoji.reaction emoji="😮" :count="3" label="Wow" />
                            <x-gsmui::emoji.reaction emoji="😢" :count="1" label="Sad" />
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-zinc-500 mb-2 uppercase tracking-wide">Active State</p>
                        <div class="flex flex-wrap gap-2">
                            <x-gsmui::emoji.reaction emoji="👍" :count="12" :active="true" label="Like" />
                            <x-gsmui::emoji.reaction emoji="❤️" :count="8" label="Love" />
                            <x-gsmui::emoji.reaction emoji="🎉" :count="15" label="Celebrate" />
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-medium text-zinc-500 mb-2 uppercase tracking-wide">Minimal (No labels)</p>
                        <div class="flex flex-wrap gap-2">
                            <x-gsmui::emoji.reaction emoji="🔥" :count="42" />
                            <x-gsmui::emoji.reaction emoji="💯" :count="28" />
                            <x-gsmui::emoji.reaction emoji="🙌" :count="19" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- 5. Emoji Picker Dropdown --}}
            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                        <span class="text-xl">🔽</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Emoji Picker Dropdown</h2>
                        <p class="text-sm text-zinc-500">Dropdown picker for forms and inputs</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4">
                    <div>
                        <p class="text-xs font-medium text-zinc-500 mb-2">Default</p>
                        <x-gsmui::emoji.picker placeholder="Pick an emoji..." />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 mb-2">Small</p>
                        <x-gsmui::emoji.picker size="sm" placeholder="Select..." />
                    </div>
                    <div>
                        <p class="text-xs font-medium text-zinc-500 mb-2">Large</p>
                        <x-gsmui::emoji.picker size="lg" placeholder="Choose emoji..." />
                    </div>
                </div>
            </div>

            {{-- 6. All Categories --}}
            <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700 p-6 lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                        <span class="text-xl">📚</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">All Emoji Categories</h2>
                        <p class="text-sm text-zinc-500">Browse all available emojis by category</p>
                    </div>
                </div>

                @php
                    $categories = [
                        ['name' => 'Smileys', 'icon' => '😀', 'emojis' => ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '🥲', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐']],
                        ['name' => 'Nature', 'icon' => '🐶', 'emojis' => ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗', '🐴']],
                        ['name' => 'Food', 'icon' => '🍕', 'emojis' => ['🍇', '🍈', '🍉', '🍊', '🍋', '🍌', '🍍', '🥭', '🍎', '🍏', '🍐', '🍑', '🍒', '🍓', '🫐', '🥝', '🍅', '🥑', '🍆', '🥔', '🥕', '🌽', '🌶️', '🥒', '🥦', '🍞', '🥐', '🥖', '🧀', '🍖', '🍗', '🥩']],
                        ['name' => 'Activities', 'icon' => '⚽', 'emojis' => ['⚽', '🏀', '🏈', '⚾', '🥎', '🎾', '🏐', '🏉', '🥏', '🎱', '🪀', '🏓', '🏸', '🏒', '🏑', '🥍', '🎮', '🎯', '🎲', '🧩', '🎸', '🎹', '🎺', '🎻', '🎬', '🎤', '🎧', '🎼', '🎵', '🎶', '🎭', '🎨']],
                        ['name' => 'Travel', 'icon' => '🚗', 'emojis' => ['🚗', '🚕', '🚙', '🚌', '🚎', '🏎️', '🚓', '🚑', '🚒', '🚐', '✈️', '🛩️', '🚀', '🛸', '🚢', '🚂', '🏠', '🏢', '🏨', '🏥', '🏫', '🏭', '🗼', '🗽', '⛪', '🕌', '🌍', '🌎', '🌏', '🗺️', '🏔️', '⛰️']],
                        ['name' => 'Objects', 'icon' => '💡', 'emojis' => ['⌚', '📱', '💻', '⌨️', '🖥️', '🖨️', '📷', '📸', '📹', '🎥', '📺', '📻', '💡', '🔦', '🕯️', '💰', '💳', '💎', '🔧', '🔩', '⚙️', '🔬', '🔭', '💊', '💉', '🔑', '🗝️', '🚪', '🪑', '🛋️', '🧶', '🧵']],
                        ['name' => 'Symbols', 'icon' => '❤️', 'emojis' => ['❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '✅', '❌', '⭕', '🛑', '⚠️', '🔄', '🆕', '🆗', '🆙', '🔝', '🔜', '🔚', '🔛', '✳️']],
                        ['name' => 'Flags', 'icon' => '🏁', 'emojis' => ['🏁', '🚩', '🎌', '🏴', '🏳️', '🇺🇸', '🇬🇧', '🇫🇷', '🇩🇪', '🇮🇹', '🇪🇸', '🇷🇺', '🇨🇳', '🇯🇵', '🇰🇷', '🇮🇳', '🇧🇷', '🇨🇦', '🇦🇺', '🇲🇽', '🇦🇷', '🇹🇷', '🇸🇦', '🇦🇪', '🇿🇦', '🇳🇬', '🇪🇬', '🇰🇪', '🇹🇭', '🇻🇳', '🇮🇩', '🇵🇭']],
                    ];
                @endphp

                <div class="space-y-6">
                    @foreach($categories as $category)
                        <div>
                            <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3 flex items-center gap-2">
                                <span class="text-xl">{{ $category['icon'] }}</span>
                                {{ $category['name'] }}
                                <span class="text-xs text-zinc-400">({{ count($category['emojis']) }})</span>
                            </h3>
                            <div class="flex flex-wrap gap-1">
                                @foreach($category['emojis'] as $emoji)
                                    <x-gsmui::emoji.display :emoji="$emoji" size="md" hoverable />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="mt-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
            <p>Gsmui Pro Emoji Components • Laravel Livewire • Tailwind CSS</p>
        </div>
    </div>
</div>
@endsection
