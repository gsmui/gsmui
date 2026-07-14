@php
/**
 * Dashboard Template Builder
 * 
 * Interactive builder for customizing dashboard templates with:
 * - Drag-and-drop widget templates
 * - Color themes (primary, secondary, accent, background)
 * - Layout options (sidebar/topbar, grid columns, spacing)
 * - Live preview
 * - Code export
 */
@endphp

<div class="min-h-screen bg-zinc-100 dark:bg-zinc-950" x-data="dashboardBuilder()">
    <!-- Header -->
    <header class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 px-6 py-4 sticky top-0 z-50">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <div class="flex items-center gap-4">
                <a href="/dashboard" class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Dashboard Builder</h1>
            </div>
            <div class="flex items-center gap-3">
                <button @click="resetDefaults()" class="px-4 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">
                    Reset
                </button>
                <button @click="showWidgets = !showWidgets" 
                        :class="showWidgets ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300'"
                        class="px-4 py-2 text-sm font-medium rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                    <span x-text="showWidgets ? 'Hide Widgets' : 'Widgets'"></span>
                </button>
                <button @click="showCode = !showCode" class="px-4 py-2 text-sm font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                    <span x-text="showCode ? 'Hide Code' : 'View Code'"></span>
                </button>
                <button @click="exportConfig()" class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Export Config
                </button>
            </div>
        </div>
    </header>

    <div class="flex max-w-7xl mx-auto">
        <!-- Widget Panel (Left) -->
        <aside x-show="showWidgets" x-transition class="w-72 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 min-h-[calc(100vh-65px)] p-4 overflow-y-auto sticky top-[65px]">
            <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Widget Templates
            </h3>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-4">Drag widgets to the preview area</p>

            <!-- Widget Categories -->
            <div class="space-y-4">
                @foreach([
                    'Stats' => [
                        ['type' => 'stat-card', 'name' => 'Stat Card', 'icon' => '📊'],
                        ['type' => 'stat-list', 'name' => 'Stat List', 'icon' => '📋'],
                        ['type' => 'stat-progress', 'name' => 'Progress Stat', 'icon' => '📈'],
                    ],
                    'Charts' => [
                        ['type' => 'bar-chart', 'name' => 'Bar Chart', 'icon' => '📊'],
                        ['type' => 'line-chart', 'name' => 'Line Chart', 'icon' => '📉'],
                        ['type' => 'pie-chart', 'name' => 'Pie Chart', 'icon' => '🥧'],
                    ],
                    'Tables' => [
                        ['type' => 'data-table', 'name' => 'Data Table', 'icon' => '📋'],
                        ['type' => 'list-table', 'name' => 'List Table', 'icon' => '📝'],
                    ],
                    'Cards' => [
                        ['type' => 'info-card', 'name' => 'Info Card', 'icon' => 'ℹ️'],
                        ['type' => 'action-card', 'name' => 'Action Card', 'icon' => '🎯'],
                        ['type' => 'user-card', 'name' => 'User Card', 'icon' => '👤'],
                    ],
                    'Media' => [
                        ['type' => 'image-card', 'name' => 'Image Card', 'icon' => '🖼️'],
                        ['type' => 'video-player', 'name' => 'Video Player', 'icon' => '🎬'],
                    ],
                ] as $widgetCategory => $widgets)
                <div>
                    <h4 class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-2 uppercase tracking-wider">{{ $widgetCategory }}</h4>
                    <div class="space-y-2">
                        @foreach($widgets as $widget)
                        <div 
                            draggable="true"
                            @dragstart="dragWidget('{{ $widget['type'] }}', '{{ $widget['name'] }}')"
                            @dragend="endDrag()"
                            class="flex items-center gap-2 p-2 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg cursor-grab hover:border-purple-400 dark:hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-all duration-200"
                        >
                            <span class="text-lg">{{ $widget['icon'] }}</span>
                            <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $widget['name'] }}</span>
                            <svg class="w-4 h-4 text-zinc-400 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                            </svg>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </aside>

        <!-- Sidebar Controls -->
        <aside class="w-80 bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 min-h-[calc(100vh-65px)] p-6 space-y-6 overflow-y-auto sticky top-[65px]">
            
            <!-- Color Theme Section -->
            <div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    Color Theme
                </h3>
                
                <!-- Primary Color -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-2">Primary Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" x-model="config.primaryColor" class="w-10 h-10 rounded-lg border border-zinc-200 dark:border-zinc-700 cursor-pointer">
                        <input type="text" x-model="config.primaryColor" class="flex-1 px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white font-mono">
                    </div>
                </div>

                <!-- Secondary Color -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-2">Secondary Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" x-model="config.secondaryColor" class="w-10 h-10 rounded-lg border border-zinc-200 dark:border-zinc-700 cursor-pointer">
                        <input type="text" x-model="config.secondaryColor" class="flex-1 px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white font-mono">
                    </div>
                </div>

                <!-- Accent Color -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-2">Accent Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" x-model="config.accentColor" class="w-10 h-10 rounded-lg border border-zinc-200 dark:border-zinc-700 cursor-pointer">
                        <input type="text" x-model="config.accentColor" class="flex-1 px-3 py-2 text-sm border border-zinc-200 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white font-mono">
                    </div>
                </div>

                <!-- Preset Themes -->
                <div>
                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-2">Preset Themes</label>
                    <div class="grid grid-cols-5 gap-2">
                        <template x-for="preset in presets" :key="preset.name">
                            <button @click="applyPreset(preset)" 
                                    :title="preset.name"
                                    class="w-10 h-10 rounded-lg border-2 transition-all duration-200 hover:scale-110"
                                    :style="`background: linear-gradient(135deg, ${preset.primary} 50%, ${preset.secondary} 50%)`"
                                    :class="config.primaryColor === preset.primary ? 'border-zinc-900 dark:border-white ring-2 ring-offset-2 ring-zinc-400' : 'border-zinc-200 dark:border-zinc-700'">
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Layout Options Section -->
            <div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                    Layout Options
                </h3>

                <!-- Header Style -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-2">Header Style</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button @click="config.headerStyle = 'topbar'" 
                                :class="config.headerStyle === 'topbar' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500 text-blue-700 dark:text-blue-400' : 'bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400'"
                                class="px-3 py-2 text-xs font-medium border rounded-lg transition-all">
                            Top Bar
                        </button>
                        <button @click="config.headerStyle = 'sidebar'" 
                                :class="config.headerStyle === 'sidebar' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500 text-blue-700 dark:text-blue-400' : 'bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400'"
                                class="px-3 py-2 text-xs font-medium border rounded-lg transition-all">
                            Sidebar
                        </button>
                        <button @click="config.headerStyle = 'minimal'" 
                                :class="config.headerStyle === 'minimal' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500 text-blue-700 dark:text-blue-400' : 'bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400'"
                                class="px-3 py-2 text-xs font-medium border rounded-lg transition-all">
                            Minimal
                        </button>
                    </div>
                </div>

                <!-- Grid Columns -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-2">Grid Columns</label>
                    <div class="flex items-center gap-3">
                        <input type="range" x-model="config.gridColumns" min="1" max="4" step="1" class="flex-1">
                        <span class="text-sm font-medium text-zinc-900 dark:text-white w-8 text-center" x-text="config.gridColumns"></span>
                    </div>
                </div>

                <!-- Spacing -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-2">Card Spacing</label>
                    <div class="flex items-center gap-3">
                        <input type="range" x-model="config.spacing" min="2" max="8" step="1" class="flex-1">
                        <span class="text-sm font-medium text-zinc-900 dark:text-white w-8 text-center" x-text="config.spacing + 'px'"></span>
                    </div>
                </div>

                <!-- Border Radius -->
                <div class="mb-4">
                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-2">Border Radius</label>
                    <div class="grid grid-cols-4 gap-2">
                        <button @click="config.borderRadius = 'none'" 
                                :class="config.borderRadius === 'none' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500' : 'bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700'"
                                class="px-2 py-1.5 text-xs border rounded-lg">
                            None
                        </button>
                        <button @click="config.borderRadius = 'sm'" 
                                :class="config.borderRadius === 'sm' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500' : 'bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700'"
                                class="px-2 py-1.5 text-xs border rounded-lg">
                            SM
                        </button>
                        <button @click="config.borderRadius = 'md'" 
                                :class="config.borderRadius === 'md' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500' : 'bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700'"
                                class="px-2 py-1.5 text-xs border rounded-lg">
                            MD
                        </button>
                        <button @click="config.borderRadius = 'lg'" 
                                :class="config.borderRadius === 'lg' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500' : 'bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700'"
                                class="px-2 py-1.5 text-xs border rounded-lg">
                            LG
                        </button>
                    </div>
                </div>
            </div>

            <!-- Dark Mode Toggle -->
            <div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    Appearance
                </h3>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Dark Mode</span>
                    <button @click="config.darkMode = !config.darkMode" 
                            :class="config.darkMode ? 'bg-blue-600' : 'bg-zinc-200 dark:bg-zinc-700'"
                            class="relative w-12 h-6 rounded-full transition-colors duration-200">
                        <span :class="config.darkMode ? 'translate-x-6' : 'translate-x-1'" 
                              class="absolute top-1 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"></span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Preview Area -->
        <main class="flex-1 p-6">
            <!-- Live Preview -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                <!-- Preview Header -->
                <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-500">Live Preview</span>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-red-400"></span>
                        <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                        <span class="w-3 h-3 rounded-full bg-green-400"></span>
                    </div>
                </div>

                <!-- Preview Content with Drop Zone -->
                <div class="p-6 min-h-[600px]" 
                     :class="[config.darkMode ? 'bg-zinc-900' : 'bg-zinc-50', isDragging ? 'ring-2 ring-purple-500 ring-inset' : '']"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="dropWidget($event)">
                    
                    <!-- Empty State -->
                    <div x-show="droppedWidgets.length === 0" class="flex flex-col items-center justify-center h-96 text-zinc-400">
                        <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-lg font-medium mb-2">Drag widgets here</p>
                        <p class="text-sm">Choose from the widget panel on the left</p>
                    </div>

                    <!-- Top Bar Header -->
                    <template x-if="config.headerStyle === 'topbar'">
                        <div class="mb-6 px-4 py-3 rounded-xl flex items-center justify-between" 
                             :style="`background-color: ${config.primaryColor}`">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white font-bold text-sm">D</div>
                                <span class="font-semibold text-white">Dashboard</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-white/20"></div>
                            </div>
                        </div>
                    </template>

                    <!-- Sidebar Header -->
                    <template x-if="config.headerStyle === 'sidebar'">
                        <div class="flex gap-6">
                            <div class="w-48 rounded-xl p-4" :style="`background-color: ${config.primaryColor}`">
                                <div class="flex items-center gap-2 mb-6">
                                    <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center text-white font-bold text-sm">D</div>
                                    <span class="font-semibold text-white text-sm">Dashboard</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white/20 text-white text-sm">Overview</div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg text-white/70 text-sm">Analytics</div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg text-white/70 text-sm">Users</div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg text-white/70 text-sm">Settings</div>
                                </div>
                            </div>
                            <div class="flex-1">
                    </template>

                    <!-- Minimal Header -->
                    <template x-if="config.headerStyle === 'minimal'">
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold" :class="config.darkMode ? 'text-white' : 'text-zinc-900'">Dashboard Overview</h1>
                            <p class="text-sm mt-1" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-500'">Welcome back! Here's what's happening today.</p>
                        </div>
                    </template>

                    <!-- Dropped Widgets -->
                    <div :class="`grid grid-cols-${config.gridColumns} gap-${config.spacing}`" class="mb-6">
                        <template x-for="(widget, index) in droppedWidgets" :key="widget.id">
                            <div class="relative group">
                                <!-- Remove Button -->
                                <button @click="removeWidget(index)" 
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity z-10 flex items-center justify-center text-xs">
                                    ×
                                </button>
                                
                                <!-- Widget Content -->
                                <div class="p-4 rounded-xl border" 
                                     :class="config.darkMode ? 'bg-zinc-800 border-zinc-700' : 'bg-white border-zinc-200'"
                                     :style="`border-radius: ${getRadius()}`">
                                    
                                    <!-- Stat Card Widget -->
                                    <template x-if="widget.type === 'stat-card'">
                                        <div>
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-xs font-medium" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-500'" x-text="widget.config.label"></span>
                                                <span class="text-lg" x-text="widget.config.icon"></span>
                                            </div>
                                            <div class="text-2xl font-bold" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.value"></div>
                                            <div class="text-xs mt-1" :class="widget.config.positive ? 'text-green-500' : 'text-red-500'">
                                                <span x-text="widget.config.positive ? '↑' : '↓'"></span>
                                                <span x-text="widget.config.change"></span>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Bar Chart Widget -->
                                    <template x-if="widget.type === 'bar-chart'">
                                        <div>
                                            <h4 class="text-sm font-medium mb-3" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <div class="h-32 flex items-end gap-1">
                                                <template x-for="(val, i) in widget.config.data" :key="i">
                                                    <div class="flex-1 rounded-t transition-all duration-300" 
                                                         :style="`height: ${val}%; background-color: ${i % 2 === 0 ? config.primaryColor : config.secondaryColor}`"></div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Line Chart Widget -->
                                    <template x-if="widget.type === 'line-chart'">
                                        <div>
                                            <h4 class="text-sm font-medium mb-3" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <div class="h-32 relative">
                                                <svg class="w-full h-full" viewBox="0 0 100 50" preserveAspectRatio="none">
                                                    <polyline fill="none" :stroke="config.primaryColor" stroke-width="2"
                                                        :points="widget.config.data.map((v, i) => `${i * (100 / (widget.config.data.length - 1))},${50 - v / 2}`).join(' ')">
                                                    </polyline>
                                                </svg>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Data Table Widget -->
                                    <template x-if="widget.type === 'data-table'">
                                        <div>
                                            <h4 class="text-sm font-medium mb-3" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <div class="space-y-2">
                                                <template x-for="(row, i) in widget.config.rows.slice(0, 3)" :key="i">
                                                    <div class="flex items-center justify-between text-sm py-1 border-b" :class="config.darkMode ? 'border-zinc-700' : 'border-zinc-100'">
                                                        <span :class="config.darkMode ? 'text-zinc-300' : 'text-zinc-600'" x-text="row.name"></span>
                                                        <span class="font-medium" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="row.value"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Info Card Widget -->
                                    <template x-if="widget.type === 'info-card'">
                                        <div class="text-center">
                                            <div class="text-3xl mb-2" x-text="widget.config.icon"></div>
                                            <h4 class="text-sm font-medium" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <p class="text-xs mt-1" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-500'" x-text="widget.config.description"></p>
                                        </div>
                                    </template>

                                    <!-- Action Card Widget -->
                                    <template x-if="widget.type === 'action-card'">
                                        <div>
                                            <h4 class="text-sm font-medium mb-3" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <div class="space-y-2">
                                                <template x-for="(action, i) in widget.config.actions" :key="i">
                                                    <div class="p-2 rounded-lg text-center text-sm font-medium cursor-pointer transition-opacity hover:opacity-90"
                                                         :style="`background-color: ${i === 0 ? config.primaryColor : 'transparent'}; ${i > 0 ? `border: 1px solid ${config.accentColor}; color: ${config.accentColor}` : 'color: white'}`"
                                                         x-text="action">
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Pie Chart Widget -->
                                    <template x-if="widget.type === 'pie-chart'">
                                        <div>
                                            <h4 class="text-sm font-medium mb-3" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <div class="flex items-center justify-center">
                                                <div class="w-24 h-24 rounded-full" 
                                                     :style="`background: conic-gradient(${config.primaryColor} 0% 40%, ${config.secondaryColor} 40% 70%, ${config.accentColor} 70% 100%)`">
                                                </div>
                                            </div>
                                            <div class="flex justify-center gap-4 mt-3 text-xs">
                                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full" :style="`background-color: ${config.primaryColor}`"></span> 40%</span>
                                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full" :style="`background-color: ${config.secondaryColor}`"></span> 30%</span>
                                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full" :style="`background-color: ${config.accentColor}`"></span> 30%</span>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- User Card Widget -->
                                    <template x-if="widget.type === 'user-card'">
                                        <div class="text-center">
                                            <div class="w-12 h-12 mx-auto rounded-full mb-2 flex items-center justify-center text-white text-lg font-bold"
                                                 :style="`background-color: ${config.primaryColor}`">
                                                <span x-text="widget.config.initials"></span>
                                            </div>
                                            <h4 class="text-sm font-medium" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.name"></h4>
                                            <p class="text-xs" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-500'" x-text="widget.config.role"></p>
                                        </div>
                                    </template>

                                    <!-- List Table Widget -->
                                    <template x-if="widget.type === 'list-table'">
                                        <div>
                                            <h4 class="text-sm font-medium mb-3" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <div class="space-y-2">
                                                <template x-for="(item, i) in widget.config.items.slice(0, 4)" :key="i">
                                                    <div class="flex items-center gap-2 text-sm">
                                                        <span class="text-lg" x-text="item.icon"></span>
                                                        <span :class="config.darkMode ? 'text-zinc-300' : 'text-zinc-600'" x-text="item.label"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Image Card Widget -->
                                    <template x-if="widget.type === 'image-card'">
                                        <div>
                                            <div class="h-24 rounded-lg mb-2 flex items-center justify-center"
                                                 :style="`background: linear-gradient(135deg, ${config.primaryColor}40, ${config.secondaryColor}40)`">
                                                <svg class="w-8 h-8" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-medium" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <p class="text-xs" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-500'" x-text="widget.config.description"></p>
                                        </div>
                                    </template>

                                    <!-- Video Player Widget -->
                                    <template x-if="widget.type === 'video-player'">
                                        <div>
                                            <div class="h-28 rounded-lg mb-2 flex items-center justify-center relative overflow-hidden"
                                                 :style="`background: linear-gradient(135deg, ${config.primaryColor}60, ${config.secondaryColor}60)`">
                                                <div class="w-10 h-10 rounded-full bg-white/90 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-zinc-900 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <h4 class="text-sm font-medium" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <p class="text-xs" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-500'" x-text="widget.config.duration"></p>
                                        </div>
                                    </template>

                                    <!-- Stat List Widget -->
                                    <template x-if="widget.type === 'stat-list'">
                                        <div>
                                            <h4 class="text-sm font-medium mb-3" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.title"></h4>
                                            <div class="space-y-2">
                                                <template x-for="(stat, i) in widget.config.stats" :key="i">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-600'" x-text="stat.label"></span>
                                                        <span class="text-sm font-medium" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="stat.value"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Progress Stat Widget -->
                                    <template x-if="widget.type === 'stat-progress'">
                                        <div>
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-medium" :class="config.darkMode ? 'text-white' : 'text-zinc-900'" x-text="widget.config.label"></span>
                                                <span class="text-sm" :class="config.darkMode ? 'text-zinc-400' : 'text-zinc-500'" x-text="widget.config.value"></span>
                                            </div>
                                            <div class="h-2 rounded-full" :class="config.darkMode ? 'bg-zinc-700' : 'bg-zinc-200'">
                                                <div class="h-full rounded-full transition-all duration-500"
                                                     :style="`width: ${widget.config.progress}%; background-color: ${config.primaryColor}`"></div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Close sidebar div if sidebar mode -->
                    <template x-if="config.headerStyle === 'sidebar'">
                        </div>
                    </template>

                </div>
            </div>

            <!-- Code Output -->
            <div x-show="showCode" x-transition class="mt-6 bg-zinc-900 rounded-xl border border-zinc-700 overflow-hidden">
                <div class="px-4 py-3 border-b border-zinc-700 flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-400">Generated Code</span>
                    <button @click="copyCode()" class="text-xs text-blue-400 hover:text-blue-300 transition-colors">
                        <span x-text="copied ? '✓ Copied!' : 'Copy Code'"></span>
                    </button>
                </div>
                <pre class="p-4 text-sm text-zinc-300 overflow-x-auto font-mono max-h-96 overflow-y-auto" x-text="generatedCode"></pre>
            </div>
        </main>
    </div>
</div>

<script>
function dashboardBuilder() {
    return {
        showCode: false,
        showWidgets: true,
        copied: false,
        isDragging: false,
        draggedWidget: null,
        draggedWidgetName: null,
        widgetCounter: 0,
        config: {
            primaryColor: '#3b82f6',
            secondaryColor: '#8b5cf6',
            accentColor: '#06b6d4',
            headerStyle: 'topbar',
            gridColumns: 4,
            spacing: 4,
            borderRadius: 'lg',
            darkMode: false,
        },
        presets: [
            { name: 'Blue', primary: '#3b82f6', secondary: '#8b5cf6', accent: '#06b6d4' },
            { name: 'Green', primary: '#10b981', secondary: '#059669', accent: '#34d399' },
            { name: 'Purple', primary: '#8b5cf6', secondary: '#a855f7', accent: '#c084fc' },
            { name: 'Red', primary: '#ef4444', secondary: '#dc2626', accent: '#f87171' },
            { name: 'Orange', primary: '#f97316', secondary: '#ea580c', accent: '#fb923c' },
            { name: 'Pink', primary: '#ec4899', secondary: '#d946ef', accent: '#f472b6' },
            { name: 'Teal', primary: '#14b8a6', secondary: '#0d9488', accent: '#2dd4bf' },
            { name: 'Indigo', primary: '#6366f1', secondary: '#818cf8', accent: '#a5b4fc' },
            { name: 'Slate', primary: '#64748b', secondary: '#475569', accent: '#94a3b8' },
            { name: 'Emerald', primary: '#10b981', secondary: '#047857', accent: '#6ee7b7' },
        ],
        droppedWidgets: [],

        getRadius() {
            const radii = { 'none': '0', 'sm': '0.375rem', 'md': '0.5rem', 'lg': '0.75rem' };
            return radii[this.config.borderRadius];
        },

        applyPreset(preset) {
            this.config.primaryColor = preset.primary;
            this.config.secondaryColor = preset.secondary;
            this.config.accentColor = preset.accent;
        },

        dragWidget(type, name) {
            this.draggedWidget = type;
            this.draggedWidgetName = name;
            this.isDragging = true;
        },

        endDrag() {
            this.isDragging = false;
        },

        dropWidget(event) {
            this.isDragging = false;
            if (!this.draggedWidget) return;

            this.widgetCounter++;
            const widget = {
                id: this.widgetCounter,
                type: this.draggedWidget,
                name: this.draggedWidgetName,
                config: this.getDefaultConfig(this.draggedWidget)
            };

            this.droppedWidgets.push(widget);
            this.draggedWidget = null;
            this.draggedWidgetName = null;
        },

        getDefaultConfig(type) {
            const configs = {
                'stat-card': { label: 'Total Revenue', value: '$45,231', icon: '💰', change: '+20.1%', positive: true },
                'stat-list': { title: 'Quick Stats', stats: [{ label: 'Users', value: '1,234' }, { label: 'Revenue', value: '$5,678' }, { label: 'Orders', value: '890' }] },
                'stat-progress': { label: 'Storage Used', value: '75%', progress: 75 },
                'bar-chart': { title: 'Monthly Sales', data: [40, 65, 45, 80, 55, 70, 90, 60] },
                'line-chart': { title: 'Traffic Trend', data: [20, 45, 30, 60, 40, 55, 70] },
                'pie-chart': { title: 'Traffic Sources' },
                'data-table': { title: 'Recent Orders', rows: [{ name: 'Order #1234', value: '$123' }, { name: 'Order #1235', value: '$456' }, { name: 'Order #1236', value: '$789' }] },
                'list-table': { title: 'Top Pages', items: [{ icon: '📄', label: '/home' }, { icon: '📄', label: '/about' }, { icon: '📄', label: '/products' }, { icon: '📄', label: '/contact' }] },
                'info-card': { icon: 'ℹ️', title: 'Getting Started', description: 'Drag widgets to build your dashboard' },
                'action-card': { title: 'Quick Actions', actions: ['New Report', 'View Analytics', 'Export Data'] },
                'user-card': { initials: 'JD', name: 'John Doe', role: 'Administrator' },
                'image-card': { title: 'Featured Image', description: 'Click to upload or drag and drop' },
                'video-player': { title: 'Intro Video', duration: '2:30' },
            };
            return configs[type] || { title: 'Widget' };
        },

        removeWidget(index) {
            this.droppedWidgets.splice(index, 1);
        },

        resetDefaults() {
            this.config = {
                primaryColor: '#3b82f6',
                secondaryColor: '#8b5cf6',
                accentColor: '#06b6d4',
                headerStyle: 'topbar',
                gridColumns: 4,
                spacing: 4,
                borderRadius: 'lg',
                darkMode: false,
            };
            this.droppedWidgets = [];
        },

        get generatedCode() {
            const r = this.getRadius();
            const widgets = this.droppedWidgets.map(w => `      <!-- ${w.name} Widget -->
      <div class="p-4 rounded-xl border ${this.config.darkMode ? 'bg-zinc-800 border-zinc-700' : 'bg-white border-zinc-200'}" style="border-radius: ${r}">
        <p class="text-sm font-medium">${w.config.label || w.config.title || w.name}</p>
      </div>`).join('\n');
            
            return `<!-- Dashboard Template - Generated by Builder -->
<div class="min-h-screen ${this.config.darkMode ? 'bg-zinc-900' : 'bg-zinc-50'}">
  <header class="px-6 py-4" style="background-color: ${this.config.primaryColor}">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <span class="font-semibold text-white">Dashboard</span>
    </div>
  </header>
  
  <main class="max-w-7xl mx-auto p-6">
    <div class="grid grid-cols-${this.config.gridColumns} gap-${this.config.spacing}">
${widgets || '      <!-- Add widgets here -->'}
    </div>
  </main>
</div>`;
        },

        copyCode() {
            navigator.clipboard.writeText(this.generatedCode);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        },

        exportConfig() {
            const exportData = {
                config: this.config,
                widgets: this.droppedWidgets.map(w => ({ type: w.type, config: w.config }))
            };
            const configStr = JSON.stringify(exportData, null, 2);
            const blob = new Blob([configStr], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'dashboard-config.json';
            a.click();
            URL.revokeObjectURL(url);
        },
    }
}
</script>
