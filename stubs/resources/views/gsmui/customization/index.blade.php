@blaze(fold: true)

@props([
    'position' => 'right',
    'open' => false,
    'id' => null,
    'showThemeSelector' => true,
    'showSettings' => true,
    'showModeToggle' => true,
    'variant' => 'default',
    'title' => __('Customize'),
    'value' => 'zinc-blue',
])

@php
$panelId = $id ?: 'customization-' . str()->random(6);
$isRight = $position === 'right';

$panelClasses = Gsmui::classes()
    ->add('fixed inset-y-0 z-50 w-72 sm:w-80 bg-white dark:bg-zinc-900 border-l border-zinc-200 dark:border-zinc-800 shadow-2xl shadow-zinc-900/10 flex flex-col transition-all duration-300 ease-in-out')
    ->add($isRight ? 'right-0' : 'left-0')
    ;
@endphp

<div
    x-data="{
        open: {{ $open ? 'true' : 'false' }},
        mode: 'light',
        theme: 'zinc-blue',
    }"
    @gsmui-theme-select.window="theme = $event.detail.theme"
    data-gsmui-customization
>
    {{-- Toggle button --}}
    <button
        type="button"
        @click="open = !open"
        class="fixed bottom-4 {{ $isRight ? 'right-4' : 'left-4' }} z-50 size-10 rounded-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 shadow-lg shadow-zinc-900/20 hover:scale-105 transition-all duration-200 flex items-center justify-center"
        aria-label="{{ __('Toggle customization') }}"
        data-gsmui-customization-toggle
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
            <path fill-rule="evenodd" d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.205 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.82 7.593a1 1 0 01-.205-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
        </svg>
    </button>

    {{-- Panel --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="{{ $isRight ? 'translate-x-full' : '-translate-x-full' }}"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="{{ $isRight ? 'translate-x-full' : '-translate-x-full' }}"
        class="{{ $panelClasses }}"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-200 dark:border-zinc-800 shrink-0">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 text-zinc-500 dark:text-zinc-400">
                    <path fill-rule="evenodd" d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.205 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.82 7.593a1 1 0 01-.205-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $title }}</h2>
            </div>
            <button type="button" @click="open = false" class="size-7 rounded-md flex items-center justify-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors" aria-label="{{ __('Close') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-5">
            {{-- Mode Toggle (Light/Dark/System) --}}
            @if ($showModeToggle)
                <div>
                    <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-2">{{ __('Color Mode') }}</label>
                    <div class="flex gap-1.5 p-1 rounded-lg bg-zinc-100 dark:bg-zinc-800">
                        <button
                            type="button"
                            @click="
                                mode = 'light';
                                document.documentElement.classList.remove('dark');
                                localStorage?.setItem('gsmui-mode', 'light');
                            "
                            :class="mode === 'light' ? 'bg-white dark:bg-zinc-700 shadow-sm text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300'"
                            class="flex-1 flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-150"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                            </svg>
                            Light
                        </button>
                        <button
                            type="button"
                            @click="
                                mode = 'dark';
                                document.documentElement.classList.add('dark');
                                localStorage?.setItem('gsmui-mode', 'dark');
                            "
                            :class="mode === 'dark' ? 'bg-white dark:bg-zinc-700 shadow-sm text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300'"
                            class="flex-1 flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-150"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                                <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 01.26.77 7 7 0 009.958 7.967.75.75 0 011.067.853A8.5 8.5 0 116.647 1.921a.75.75 0 01.808.083z" clip-rule="evenodd" />
                            </svg>
                            Dark
                        </button>
                        <button
                            type="button"
                            @click="
                                mode = 'system';
                                localStorage?.removeItem('gsmui-mode');
                                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                                    document.documentElement.classList.add('dark');
                                } else {
                                    document.documentElement.classList.remove('dark');
                                }
                            "
                            :class="mode === 'system' ? 'bg-white dark:bg-zinc-700 shadow-sm text-zinc-900 dark:text-white' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300'"
                            class="flex-1 flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md transition-all duration-150"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v5a2 2 0 002 2h5l-1.414 1.414A1 1 0 007 16h6a1 1 0 00.707-1.707L12.293 13H16a2 2 0 002-2V6a2 2 0 00-2-2H4z" clip-rule="evenodd" />
                            </svg>
                            System
                        </button>
                    </div>
                </div>
            @endif

            {{-- Theme Selector --}}
            @if ($showThemeSelector)
                <gsmui:customization.theme-selector
                    :value="$value ?? 'zinc-blue'"
                    @theme-selected.window="theme = $event.detail.theme"
                />
            @endif

            {{-- Settings (radius, shadow, font) --}}
            @if ($showSettings)
                <gsmui:customization.settings compact />
            @endif
        </div>

        {{-- Footer --}}
        <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-800 shrink-0">
            <button
                type="button"
                @click="open = false"
                class="w-full px-3 py-2 text-xs font-medium rounded-lg bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 hover:bg-zinc-800 dark:hover:bg-zinc-100 transition-colors"
            >
                {{ __('Done') }}
            </button>
        </div>
    </div>
</div>
