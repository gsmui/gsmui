@props([
    'size' => 'md',
])

@php
$variants = [
    // Core styles
    ['id' => 'basic', 'name' => 'Basic Dock', 'category' => 'Core', 'desc' => 'Standard dock with hover magnification.'],
    ['id' => 'macos', 'name' => 'macOS Dock', 'category' => 'Core', 'desc' => 'Authentic macOS-style with reflection.'],
    ['id' => 'minimal', 'name' => 'Minimal', 'category' => 'Core', 'desc' => 'Clean, minimal design.'],
    ['id' => 'compact', 'name' => 'Compact', 'category' => 'Core', 'desc' => 'Smaller icons, tight spacing.'],
    ['id' => 'expanded', 'name' => 'Expanded', 'category' => 'Core', 'desc' => 'With visible labels.'],
    ['id' => 'icons-only', 'name' => 'Icons Only', 'category' => 'Core', 'desc' => 'No labels, just icons.'],
    ['id' => 'centered', 'name' => 'Centered', 'category' => 'Core', 'desc' => 'Centered with labels below.'],
    
    // Layouts
    ['id' => 'vertical', 'name' => 'Vertical', 'category' => 'Layout', 'desc' => 'Vertical orientation.'],
    ['id' => 'sidebar-left', 'name' => 'Left Sidebar', 'category' => 'Layout', 'desc' => 'Fixed left sidebar.'],
    ['id' => 'sidebar-right', 'name' => 'Right Sidebar', 'category' => 'Layout', 'desc' => 'Fixed right sidebar.'],
    ['id' => 'top-dock', 'name' => 'Top Dock', 'category' => 'Layout', 'desc' => 'Top-positioned navigation.'],
    ['id' => 'mobile', 'name' => 'Mobile', 'category' => 'Layout', 'desc' => 'Touch-optimized for mobile.'],
    ['id' => 'desktop', 'name' => 'Desktop', 'category' => 'Layout', 'desc' => 'Desktop-optimized with tooltips.'],
    ['id' => 'responsive', 'name' => 'Responsive', 'category' => 'Layout', 'desc' => 'Adapts to screen size.'],
    ['id' => 'taskbar', 'name' => 'Taskbar', 'category' => 'Layout', 'desc' => 'Windows-style taskbar.'],
    
    // Effects
    ['id' => 'glass', 'name' => 'Glass', 'category' => 'Effects', 'desc' => 'Glassmorphism style.'],
    ['id' => 'glass-heavy', 'name' => 'Heavy Glass', 'category' => 'Effects', 'desc' => 'Strong blur and transparency.'],
    ['id' => 'glass-morphism', 'name' => 'Glass Morphism', 'category' => 'Effects', 'desc' => 'Frosted glass with tint.'],
    ['id' => 'frosted', 'name' => 'Frosted', 'category' => 'Effects', 'desc' => 'Subtle transparency.'],
    ['id' => 'translucent', 'name' => 'Translucent', 'category' => 'Effects', 'desc' => 'Semi-transparent background.'],
    ['id' => 'glow', 'name' => 'Glow', 'category' => 'Effects', 'desc' => 'Glowing effect.'],
    ['id' => 'neon', 'name' => 'Neon', 'category' => 'Effects', 'desc' => 'Neon glow style.'],
    ['id' => 'neon-ring', 'name' => 'Neon Ring', 'category' => 'Effects', 'desc' => 'Circular neon container.'],
    ['id' => 'cyberpunk', 'name' => 'Cyberpunk', 'category' => 'Effects', 'desc' => 'Futuristic neon style.'],
    ['id' => 'pulse', 'name' => 'Pulse', 'category' => 'Effects', 'desc' => 'Pulse animation.'],
    ['id' => 'ripple', 'name' => 'Ripple', 'category' => 'Effects', 'desc' => 'Click ripple effect.'],
    ['id' => 'liquid', 'name' => 'Liquid', 'category' => 'Effects', 'desc' => 'Fluid morphing shapes.'],
    
    // Gradients
    ['id' => 'gradient', 'name' => 'Gradient', 'category' => 'Gradients', 'desc' => 'Gradient stroke effect.'],
    ['id' => 'gradient-bg', 'name' => 'Gradient BG', 'category' => 'Gradients', 'desc' => 'Gradient background.'],
    ['id' => 'gradient-border', 'name' => 'Gradient Border', 'category' => 'Gradients', 'desc' => 'Gradient border effect.'],
    ['id' => 'gradient-text', 'name' => 'Gradient Text', 'category' => 'Gradients', 'desc' => 'Gradient text labels.'],
    ['id' => 'dual-tone', 'name' => 'Dual Tone', 'category' => 'Gradients', 'desc' => 'Two-tone split design.'],
    
    // Animations
    ['id' => 'animated', 'name' => 'Animated', 'category' => 'Animation', 'desc' => 'Smooth transitions.'],
    ['id' => 'bounce', 'name' => 'Bounce', 'category' => 'Animation', 'desc' => 'Bounce animation.'],
    ['id' => 'magnify', 'name' => 'Magnify', 'category' => 'Animation', 'desc' => 'Magnification effect.'],
    ['id' => 'zoom', 'name' => 'Zoom', 'category' => 'Animation', 'desc' => 'Zoom on hover.'],
    ['id' => 'hover-expand', 'name' => 'Hover Expand', 'category' => 'Animation', 'desc' => 'Expand on hover.'],
    ['id' => 'expandable', 'name' => 'Expandable', 'category' => 'Animation', 'desc' => 'Grows with labels.'],
    ['id' => 'rotating', 'name' => 'Rotating', 'category' => 'Animation', 'desc' => 'Rotation on hover.'],
    ['id' => 'flip', 'name' => 'Flip', 'category' => 'Animation', 'desc' => '3D flip animation.'],
    ['id' => 'spring', 'name' => 'Spring', 'category' => 'Animation', 'desc' => 'Springy bounce.'],
    ['id' => 'morph', 'name' => 'Morph', 'category' => 'Animation', 'desc' => 'Shape morphing.'],
    ['id' => 'collapsible', 'name' => 'Collapsible', 'category' => 'Animation', 'desc' => 'Collapse/expand toggle.'],
    
    // Shapes
    ['id' => 'pill', 'name' => 'Pill', 'category' => 'Shapes', 'desc' => 'Fully rounded corners.'],
    ['id' => 'squared', 'name' => 'Squared', 'category' => 'Shapes', 'desc' => 'Sharp corners.'],
    ['id' => 'flat', 'name' => 'Flat', 'category' => 'Shapes', 'desc' => 'No shadows or depth.'],
    ['id' => 'bubble', 'name' => 'Bubble', 'category' => 'Shapes', 'desc' => 'Bubble-like buttons.'],
    ['id' => 'circular', 'name' => 'Circular', 'category' => 'Shapes', 'desc' => 'Radial arrangement.'],
    ['id' => 'arc', 'name' => 'Arc', 'category' => 'Shapes', 'desc' => 'Curved layout.'],
    ['id' => 'wave', 'name' => 'Wave', 'category' => 'Shapes', 'desc' => 'Undulating layout.'],
    
    // Depth
    ['id' => 'shadow', 'name' => 'Shadow', 'category' => 'Depth', 'desc' => 'Prominent shadows.'],
    ['id' => 'elevated', 'name' => 'Elevated', 'category' => 'Depth', 'desc' => 'Layered shadows.'],
    ['id' => 'layered', 'name' => 'Layered', 'category' => 'Depth', 'desc' => 'Multi-layer depth.'],
    
    // Themes
    ['id' => 'dark', 'name' => 'Dark', 'category' => 'Themes', 'desc' => 'Dark mode optimized.'],
    ['id' => 'light', 'name' => 'Light', 'category' => 'Themes', 'desc' => 'Light mode optimized.'],
    ['id' => 'retro', 'name' => 'Retro', 'category' => 'Themes', 'desc' => 'Vintage design.'],
    ['id' => 'pixel', 'name' => 'Pixel', 'category' => 'Themes', 'desc' => 'Pixel art style.'],
    ['id' => 'terminal', 'name' => 'Terminal', 'category' => 'Themes', 'desc' => 'Command-line style.'],
    ['id' => 'cyberpunk', 'name' => 'Cyberpunk', 'category' => 'Themes', 'desc' => 'Futuristic neon.'],
    ['id' => 'metallic', 'name' => 'Metallic', 'category' => 'Themes', 'desc' => 'Chrome appearance.'],
    ['id' => 'wooden', 'name' => 'Wooden', 'category' => 'Themes', 'desc' => 'Natural wood texture.'],
    ['id' => 'paper', 'name' => 'Paper', 'category' => 'Themes', 'desc' => 'Paper texture.'],
    ['id' => 'crystal', 'name' => 'Crystal', 'category' => 'Themes', 'desc' => 'Faceted glass.'],
    
    // Structure
    ['id' => 'bordered', 'name' => 'Bordered', 'category' => 'Structure', 'desc' => 'Prominent borders.'],
    ['id' => 'dashed', 'name' => 'Dashed', 'category' => 'Structure', 'desc' => 'Dashed borders.'],
    ['id' => 'dotted', 'name' => 'Dotted', 'category' => 'Structure', 'desc' => 'Dotted pattern.'],
    ['id' => 'striped', 'name' => 'Striped', 'category' => 'Structure', 'desc' => 'Striped background.'],
    ['id' => 'solid', 'name' => 'Solid', 'category' => 'Structure', 'desc' => 'Solid background.'],
    ['id' => 'split', 'name' => 'Split', 'category' => 'Structure', 'desc' => 'Main and secondary sections.'],
    ['id' => 'segmented', 'name' => 'Segmented', 'category' => 'Structure', 'desc' => 'Distinct sections.'],
    ['id' => 'grouped', 'name' => 'Grouped', 'category' => 'Structure', 'desc' => 'Grouped with dividers.'],
    ['id' => 'stacked', 'name' => 'Stacked', 'category' => 'Structure', 'desc' => 'Multi-row grid.'],
    ['id' => 'stepped', 'name' => 'Stepped', 'category' => 'Structure', 'desc' => 'Staggered heights.'],
    ['id' => 'dual-tone', 'name' => 'Dual Tone', 'category' => 'Structure', 'desc' => 'Split color design.'],
    
    // Sizes
    ['id' => 'nano', 'name' => 'Nano', 'category' => 'Sizes', 'desc' => 'Ultra-compact.'],
    ['id' => 'mini', 'name' => 'Mini', 'category' => 'Sizes', 'desc' => 'Smaller sizing.'],
    ['id' => 'large', 'name' => 'Large', 'category' => 'Sizes', 'desc' => 'Bigger icons, more spacing.'],
    
    // Interactive
    ['id' => 'with-dropdown', 'name' => 'With Dropdown', 'category' => 'Interactive', 'desc' => 'Dropdown menus.'],
    ['id' => 'with-submenu', 'name' => 'With Submenu', 'category' => 'Interactive', 'desc' => 'Nested submenus.'],
    ['id' => 'context-menu', 'name' => 'Context Menu', 'category' => 'Interactive', 'desc' => 'Right-click menus.'],
    ['id' => 'mega', 'name' => 'Mega Dock', 'category' => 'Interactive', 'desc' => 'Large preview panels.'],
    ['id' => 'dock-tabs', 'name' => 'Dock Tabs', 'category' => 'Interactive', 'desc' => 'Tabbed sections.'],
    ['id' => 'dock-drawer', 'name' => 'Dock Drawer', 'category' => 'Interactive', 'desc' => 'Slide-out drawer.'],
    ['id' => 'dock-modal', 'name' => 'Dock Modal', 'category' => 'Interactive', 'desc' => 'Centered overlay.'],
    
    // Content
    ['id' => 'with-labels', 'name' => 'With Labels', 'category' => 'Content', 'desc' => 'Visible text labels.'],
    ['id' => 'with-tooltip', 'name' => 'With Tooltip', 'category' => 'Content', 'desc' => 'Hover tooltips.'],
    ['id' => 'with-badge', 'name' => 'With Badge', 'category' => 'Content', 'desc' => 'Notification badges.'],
    ['id' => 'with-badges', 'name' => 'With Badges', 'category' => 'Content', 'desc' => 'Badge indicators.'],
    ['id' => 'with-count', 'name' => 'With Count', 'category' => 'Content', 'desc' => 'Count badges.'],
    ['id' => 'with-notifications', 'name' => 'Notifications', 'category' => 'Content', 'desc' => 'Notification dots.'],
    ['id' => 'with-icon-text', 'name' => 'Icon + Text', 'category' => 'Content', 'desc' => 'Side-by-side layout.'],
    ['id' => 'with-avatar', 'name' => 'With Avatar', 'category' => 'Content', 'desc' => 'Avatar images.'],
    ['id' => 'with-image', 'name' => 'With Image', 'category' => 'Content', 'desc' => 'Image thumbnails.'],
    ['id' => 'with-progress', 'name' => 'With Progress', 'category' => 'Content', 'desc' => 'Progress indicators.'],
    ['id' => 'with-status', 'name' => 'With Status', 'category' => 'Content', 'desc' => 'Status indicators.'],
    ['id' => 'with-search', 'name' => 'With Search', 'category' => 'Content', 'desc' => 'Search input.'],
    ['id' => 'with-header', 'name' => 'With Header', 'category' => 'Content', 'desc' => 'Header section.'],
    ['id' => 'with-section', 'name' => 'With Section', 'category' => 'Content', 'desc' => 'Section dividers.'],
    ['id' => 'with-separator', 'name' => 'With Separator', 'category' => 'Content', 'desc' => 'Separator lines.'],
    ['id' => 'with-shortcut', 'name' => 'With Shortcut', 'category' => 'Content', 'desc' => 'Keyboard shortcuts.'],
    
    // App styles
    ['id' => 'app-launcher', 'name' => 'App Launcher', 'category' => 'Apps', 'desc' => 'App grid launcher.'],
    ['id' => 'docklet', 'name' => 'Docklet', 'category' => 'Apps', 'desc' => 'Small widget dock.'],
    ['id' => 'quick-action', 'name' => 'Quick Action', 'category' => 'Apps', 'desc' => 'Prominent actions.'],
    ['id' => 'chrome', 'name' => 'Chrome', 'category' => 'Apps', 'desc' => 'Browser tab style.'],
    ['id' => 'scroll', 'name' => 'Scroll', 'category' => 'Apps', 'desc' => 'Scrollable dock.'],
];

$categories = collect($variants)->groupBy('category');
@endphp

<div {{ $attributes }}>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Dock Components</h1>
        <p class="mt-2 text-zinc-500 dark:text-zinc-400">{{ count($variants) }} variants across {{ count($categories) }} categories</p>
    </div>
    
    @foreach($categories as $category => $items)
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-white mb-4">{{ $category }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($items as $variant)
                    <a href="{{ route('gsmui.dock.' . $variant['id']) }}" 
                       class="block p-4 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
                        <h3 class="font-medium text-zinc-900 dark:text-white">{{ $variant['name'] }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $variant['desc'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
